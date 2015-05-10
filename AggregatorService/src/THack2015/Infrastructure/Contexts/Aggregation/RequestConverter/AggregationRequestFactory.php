<?php


namespace THack2015\Infrastructure\Contexts\Aggregation\RequestConverter;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use THack2015\Domain\Contexts\Aggregation\Aggregates\AggregationRequest;
use THack2015\Domain\Contexts\Aggregation\Collections\Flights;
use THack2015\Domain\Contexts\Aggregation\Collections\FlightSchedules;
use THack2015\Domain\Contexts\Aggregation\Collections\HotelStays;
use THack2015\Domain\Contexts\Aggregation\Entities\Flight;
use THack2015\Domain\Contexts\Aggregation\Entities\FlightSchedule;
use THack2015\Domain\Contexts\Aggregation\Entities\HotelStay;
use THack2015\Domain\Contexts\Aggregation\Services\AggregationStrategy;

class AggregationRequestFactory
{


    public function create(Request $request, AggregationStrategy $aggregationStrategy)
    {

        $flightSchedulesJson = json_decode($request->get('flightSchedules', null), true);
        $hotelStaysJson = json_decode($request->get('hotelStays', null), true);

        if (!$flightSchedulesJson || !$hotelStaysJson) {
            throw new BadRequestHttpException("Invalid FlightSchedules and/or HotelStays.");
        }

        $hotelStays = new HotelStays();
        $flightSchedules = new FlightSchedules();

        foreach ($flightSchedulesJson as $flightSchedule) {

            $flightSchedules->add(
                new FlightSchedule(
                    $this->createFlights($flightSchedule['flight']),
                    $flightSchedule['totalPrice'],
                    $flightSchedule['totalTime']
                )

            );
        }

        foreach($hotelStaysJson as $hotelStay) {
            $hotelStays->add(
                new HotelStay(
                    $hotelStay['HotelId'],
                    $hotelStay['Hotel']['hotel_name'],
                    $hotelStay['LocationName'],
                    $hotelStay['Longitude'],
                    $hotelStay['Latitude'],
                    $hotelStay['Price'],
                    $hotelStay['Hotel']['images']

                )
            );
        }


        return new AggregationRequest($flightSchedules, $hotelStays, $aggregationStrategy);

    }

    private function createFlights($arrayOfFlights) {

        $flights = new Flights();

        foreach($arrayOfFlights as $flight) {

            $flights->add(new Flight(
                $flight['departureAirportCode'],
                $flight['departureAirportName'],
                $flight['departureAirportLongitude'],
                $flight['departureAirportLatitude'],
                $flight['departureTime'],
                $flight['arrivalAirportCode'],
                $flight['arrivalAirportName'],
                $flight['arrivalAirportLongitude'],
                $flight['arrivalAirportLatitude'],
                $flight['arrivalTime'],
                $flight['carrier']
            ));

        }

        return $flights;

    }
}