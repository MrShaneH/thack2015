<?php

require_once __DIR__ . '/../vendor/autoload.php';

/**
 * @var Silex\Application $app
 */
$app = include(__DIR__ . '/../app/container.php');

$app->get(
    '/search/{eventCategory}/{longitude}/{latitude}',
    function (\Symfony\Component\HttpFoundation\Request $request) use ($app) {

        $event = $request->get('eventCategory');
        $longitude = $request->get('longitude');
        $latitude = $request->get('latitude');

        if (!$event || !$longitude || !$latitude) {
            throw new \Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
        }

        $client = new \GuzzleHttp\Client();

        try {
            $eventsApi = "http://" . $app['infrastructure.search.events_api_domain'] . "/getEvents/" . $event;
            $events = json_decode($client->get($eventsApi)->getBody());
        } catch (\Exception $e) {
            throw new \Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;
        }

        if (!$events) {
            throw new \Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;
        }
        $pdo = new \PDO("sqlite:../airports");

        $deals = [];

        foreach ($events as $event) {

            try {
                $locationName = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $event->locationName);

                $cities = $pdo->query("SELECT * from airports WHERE city = " . $pdo->quote($locationName))->fetchAll();

                if (count($cities) == 0) {
                    continue;
                }

                //Just take the first city.
                $city = current($cities);
                $dateArrival = date("Y-m-d", strtotime($event->date));

                $flightApi = "http://" . $app['infrastructure.search.flights_api_domain'] . "/getFlights/" . $longitude . "/" . $latitude . "/" . $dateArrival . "/" . $city['id'];

                $data = json_decode($client->get($flightApi)->getBody());

                //No flights?
                if (count($data) == 0) {
                    continue;
                }

                //Consider, let's say - five flights
                $flights = array_slice($data, 0, 5);


                $oneDayBefore = date("Y-m-d", strtotime($event->date) - 86400);
                $oneDayAfter = date("Y-m-d", strtotime($event->date) + 86400);

                $hotelApi = "http://" . $app['infrastructure.search.hotels_api_domain'] . "/api/hotel?latitude=" . $event->latitude . "&longitude=" . $event->longitude . "&radius=15&startDate=" . $oneDayBefore . "&endDate=" . $oneDayAfter . "&limit=10";
                $possibleHotels = json_decode($client->get($hotelApi)->getBody());
                $possibleHotels = $possibleHotels->HotelStays;

                $aggregatorApi = "http://".$app['infrastructure.search.aggregator_api_domain']."/getDeals";

                $postData = [
                    'hotelStays' => json_encode($possibleHotels),
                    'flightSchedules' => json_encode($flights)
                ];


                $aggregatedDeals = $client->post($aggregatorApi,['body' => $postData]);

                $dealsPart = json_decode($aggregatedDeals->getBody()->getContents());

                $eventData = [
                    "id" => $event->eventId,
                    "date" => $event->date,
                    "name" => $event->locationName,
                    "latitude" => $event->latitude,
                    "longitude" => $event->longitude,
                ];

                foreach($dealsPart as $k => $aggregatedDeal) {
                    $dealsPart[$k]->event = $eventData;
                }

                $deals = array_merge($deals,$dealsPart);

                /*
                //We map them to dates and aggregate queries.
                $flightDateMaps = [];

                foreach($flights as $flightSchedule) {

                    $subflights = $flightSchedule->flight;
                    $startTime = $subflights[0]->departureTime;
                    $endTime = $subflights[count($subflights)-1]->departureTime;
                    $key = date("Y-m-d",strtotime($startTime));
                    $endKey = date("Y-m-d",strtotime($endTime));


                    if(!isset($flightDateMaps[$key])) {
                        $flightDateMaps[$key] = [];
                    }

                    if(!isset($flightDateMaps[$key][$endKey])) {
                        $flightDateMaps[$key][$endKey] = [];
                    }





                    $flightDateMaps[$key][$endKey][] = $flightSchedule;

                }

                $aggregatingCalls = [];

                foreach($flightDateMaps as $startDate => $possibilities) {

                    foreach($possibilities as $endDate => $possibleFlights) {

                        if($startDate == $endDate) {
                            $possibleHotels = [];
                        } else {
                            $hotelApi = "http://" . $app['infrastructure.search.hotels_api_domain'] . "/api/hotel?latitude=" . $event->latitude . "&longitude=" . $event->longitude . "&radius=15&startDate=" . $startDate . "&endDate=" . $endDate."&limit=10";
                            $possibleHotels = json_decode($client->get($hotelApi)->getBody());
                        }

                        $aggregatingCalls[] = ["flights" => $possibleFlights, "hotels" => $possibleHotels];
                    }

                }

                */

            } catch (\Exception $e) {
                //In case any exception occurs, just scrap it..
                continue;
            }
        }


        return new \Symfony\Component\HttpFoundation\JsonResponse(json_encode($deals));
    }
);

$app->run();
