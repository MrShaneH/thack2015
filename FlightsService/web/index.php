<?php

require_once __DIR__ . '/../vendor/autoload.php';

/**
 * @var Silex\Application $app
 */
$app = include(__DIR__ . '/../app/container.php');

$app->get(
    '/getFlights/{longitude}/{latitude}/{arrivalTime}/{destinationLongitude}/{destinationLatitude}',
    function (\Symfony\Component\HttpFoundation\Request $request) use ($app) {

        /**
         * @var THack2015\Domain\Contexts\Flights\Repository\FlightsRepository $flightsRepository
         */
        $flightsRepository = $app['infrastructure.flights.flight_repository'];
        $longitude = $request->get('longitude', null);
        $latitude = $request->get('latitude', null);
        $arrivalTime = $request->get('arrivalTime', null);
        $destinationLongitude = $request->get('destinationLongitude', null);
        $destinationLatitude = $request->get('destinationLatitude', null);



        if(!$longitude || !$latitude  || !$arrivalTime || !$destinationLongitude || !$destinationLatitude) {
            throw new \Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
        }

        $arrivalTime = new \DateTime($arrivalTime);
        $flights = $flightsRepository->findForPointAndTime($longitude, $latitude, $arrivalTime, $destinationLongitude, $destinationLatitude);

        return new \Symfony\Component\HttpFoundation\JsonResponse($flights->toArray());
    }
);

$app->run();
