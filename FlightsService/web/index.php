<?php

require_once __DIR__ . '/../vendor/autoload.php';

/**
 * @var Silex\Application $app
 */
$app = include(__DIR__ . '/../app/container.php');

$app->get(
    '/getFlights/{longitude}/{latitude}/{arrivalTime}/{destinationAirport}',
    function (\Symfony\Component\HttpFoundation\Request $request) use ($app) {

        /**
         * @var THack2015\Domain\Contexts\Flights\Repository\FlightsRepository $flightsRepository
         */
        $flightsRepository = $app['infrastructure.flights.flight_repository'];
        $longitude = $request->get('longitude', null);
        $latitude = $request->get('latitude', null);
        $arrivalTime = $request->get('arrivalTime', null);
        $destinationAirport = $request->get('destinationAirport', null);

        if(!$longitude || !$latitude || !$destinationAirport || !$arrivalTime) {
            throw new \Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
        }
        $arrivalTime = new \DateTime($arrivalTime);
        $flights = $flightsRepository->findForPointAndTime($longitude, $latitude, $arrivalTime, $destinationAirport);

        return new \Symfony\Component\HttpFoundation\JsonResponse($flights->toArray());
    }
);

$app->run();
