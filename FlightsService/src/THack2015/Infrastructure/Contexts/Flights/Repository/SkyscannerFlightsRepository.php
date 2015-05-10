<?php


namespace THack2015\Infrastructure\Contexts\Flights\Repository;

use GuzzleHttp\Client;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;
use THack2015\Domain\Contexts\Flights\Aggregates\FlightSchedule;
use THack2015\Domain\Contexts\Flights\Collections\Flights;
use THack2015\Domain\Contexts\Flights\Collections\FlightSchedules;
use THack2015\Domain\Contexts\Flights\Entities\Flight;
use THack2015\Domain\Contexts\Flights\Repository\FlightsRepository;
use THack2015\Infrastructure\Cache\CacheAccess;

class SkyscannerFlightsRepository implements FlightsRepository
{

    private $eventApiKey;

    private $client;

    private $pdo;

    public function __construct($eventApiKey)
    {
        $this->eventApiKey = $eventApiKey;
        $this->client = new Client();
        $this->pdo = new \PDO("sqlite:../airports");
        $this->pdo->sqliteCreateFunction(
            'distance',
            function () {
                if (count($geo = array_map('deg2rad', array_filter(func_get_args(), 'is_numeric'))) == 4) {
                    return round(
                        acos(
                            sin($geo[0]) * sin($geo[2]) + cos($geo[0]) * cos($geo[2]) * cos($geo[1] - $geo[3])
                        ) * 6378.14,
                        3
                    );
                }

                return null;
            },
            4
        );
    }

    public function findForPointAndTime($longitude, $latitude, \DateTime $arrivalTime, $destinationAirport)
    {

        $inboundData = $this->pdo->query(
            "SELECT * FROM airports ORDER BY distance(latitude,longitude," . $latitude . "," . $longitude . ") ASC LIMIT 1"
        );

        $airports = $inboundData->fetchAll();
        $airport = current($airports);

        $arrivalTimeOneDayBefore = $arrivalTime->setTimestamp($arrivalTime->getTimestamp() - 3600 * 24);
        $arrivalTimeTwoDaysAfter = $arrivalTime->setTimestamp($arrivalTime->getTimestamp() + 3600 * 48);

        $apiUrl = "http://partners.api.skyscanner.net/apiservices/pricing/v1.0";

        //apiKey=prtl6749387986743898559646983194&country=PL&currency=EUR&locale=en-GB&originplace=WAW-Iata&destinationplace=DUB-Iata&outbounddate=2015-05-19&inbounddate=2015-05-22
        $creationData = [
            'apiKey' => $this->eventApiKey,
            'country' => 'IR',
            'currency' => 'EUR',
            'locale' => 'en-GB',
            'originplace' => $airport['id'] . '-Iata',
            'destinationplace' => $destinationAirport . '-Iata',
            'outbounddate' => $arrivalTimeOneDayBefore->format("Y-m-d"),
            'inbounddate' => $arrivalTimeTwoDaysAfter->format("Y-m-d")

        ];

        $polledRequest = $this->client->post($apiUrl, ['body' => $creationData]);

        if ($polledRequest->getStatusCode() != 201) {
            throw new ServiceUnavailableHttpException; //Unavailable
        }

        $pollingUrl = $polledRequest->getHeader('Location') . "?apiKey=" . $this->eventApiKey;

        sleep(1); //Sleep one second.. perhaps we will implement more?

        $data = json_decode(file_get_contents($pollingUrl));

        $flightSchedules = new FlightSchedules();
        $this->populateFlightSchedules($flightSchedules, $data);

        return $flightSchedules;
    }

    private function populateFlightSchedules(FlightSchedules $flightSchedules, $data)
    {

        $carriers = [];
        foreach ($data->Carriers as $carrier) {
            $carriers[$carrier->Id] = $carrier->Name;
        }

        $places = [];

        $predicates = [];

        $codesToPlaces = [];

        foreach ($data->Places as $place) {

            if ($place->Type != "Airport") {
                continue;
            }

            $places[$place->Id] = [$place->Code, $place->Name];
            $codesToPlaces[$place->Code] = $place->Id;
            $predicates[] = "id = '" . $place->Code . "'";
        }

        $destinationData = $this->pdo->query(
            "SELECT id,longitude,latitude FROM airports WHERE " . implode(
                ' OR ',
                $predicates
            )
        )->fetchAll();

        foreach ($destinationData as $destData) {
            $places[$codesToPlaces[$destData['id']]][] = $destData['longitude'];
            $places[$codesToPlaces[$destData['id']]][] = $destData['latitude'];
        }

        /**
         * @var Flight[] $segments
         */
        $segments = [];

        foreach ($data->Segments as $segment) {

            $segments[$segment->Id] = new Flight(
                $places[$segment->OriginStation][0],
                $places[$segment->OriginStation][1],
                $places[$segment->OriginStation][2],
                $places[$segment->OriginStation][3],
                new \DateTime($segment->DepartureDateTime),
                $places[$segment->DestinationStation][0],
                $places[$segment->DestinationStation][1],
                $places[$segment->DestinationStation][2],
                $places[$segment->DestinationStation][3],
                new \DateTime($segment->ArrivalDateTime),
                $carriers[$segment->Carrier]
            );
        }

        $legs = [];

        foreach ($data->Legs as $leg) {
            $legs[$leg->Id] = $leg;
        }

        foreach ($data->Itineraries as $itinerary) {

            $flights = new Flights();
            $dates = [];

            foreach ($legs[$itinerary->OutboundLegId]->SegmentIds as $segmentId) {

                $flights->add(
                    $segments[$segmentId]
                );

                $dates[] = $segments[$segmentId]->getDepartureTime()->getTimestamp();
                $dates[] = $segments[$segmentId]->getArrivalTime()->getTimestamp();

            }

            foreach ($legs[$itinerary->InboundLegId]->SegmentIds as $segmentId) {

                $flights->add(
                    $segments[$segmentId]
                );

                $dates[] = $segments[$segmentId]->getDepartureTime()->getTimestamp();
                $dates[] = $segments[$segmentId]->getArrivalTime()->getTimestamp();

            }

            sort($dates);
            $totalTime = array_pop($dates) - $dates[0];

            $d = floor($totalTime / 86400);
            $totalTime -= $d * 86400;
            $h = floor($totalTime / 3600);
            $totalTime -= $h * 3600;
            $m = floor($totalTime / 60);

            $string = $d."d".$h."h".$m."m";


            $flightSchedules->add(new FlightSchedule($flights, $itinerary->PricingOptions[0]->Price, $totalTime));

        }


    }
}