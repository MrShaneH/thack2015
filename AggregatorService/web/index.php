<?php

require_once __DIR__ . '/../vendor/autoload.php';

/**
 * @var Silex\Application $app
 */
$app = include(__DIR__ . '/../app/container.php');

$app->post(
    '/getDeals',
    function (\Symfony\Component\HttpFoundation\Request $request) use ($app) {
        $aggregationRequestFactory = $app['infrastructure.aggregation.aggregation_request_factory'];
        $aggregationStrategyFactory = $app['infrastructure.aggregation.aggregation_strategy_factory'];

        /**
         * @var \THack2015\Infrastructure\Contexts\Aggregation\RequestConverter\AggregationRequestFactory $aggregationRequestFactory
         * @var \THack2015\Infrastructure\Contexts\Aggregation\RequestConverter\AggregationStrategyFactory $aggregationStrategyFactory
         */
        $aggregationRequest = $aggregationRequestFactory->create($request, $aggregationStrategyFactory->create($request));

        return new \Symfony\Component\HttpFoundation\JsonResponse($aggregationRequest->getBestDeals());
    }
);

$app->get(
    '/mockedDeals',
    function (\Symfony\Component\HttpFoundation\Request $request) use ($app) {
        $flightSchedules =
            new \THack2015\Domain\Contexts\Aggregation\Collections\FlightSchedules();

        $hotelStays = new \THack2015\Domain\Contexts\Aggregation\Collections\HotelStays();

        $oneFlights = new \THack2015\Domain\Contexts\Aggregation\Collections\Flights();
        $oneFlights->add(
            new \THack2015\Domain\Contexts\Aggregation\Entities\Flight(
                "WAW",
                "Warsaw",
                0,
                0,
                time(),
                "LIV",
                "Liverpool",
                50,
                50,
                time() + 3600,
                "Ryanair"
            )
        );
        $oneFlights->add(
            new \THack2015\Domain\Contexts\Aggregation\Entities\Flight(
                "LIV",
                "Liverpool",
                50,
                50,
                time() + 10800,
                "DUB",
                "Dublin",
                100,
                100,
                time() + 13500,
                "Ryanair"
            )
        );

        $directExpensive = new  \THack2015\Domain\Contexts\Aggregation\Collections\Flights();;

        $directExpensive->add(
            new \THack2015\Domain\Contexts\Aggregation\Entities\Flight(
                "WAW",
                "Warsaw",
                0,
                0,
                time(),
                "DUB",
                "Dublin",
                100,
                100,
                time() + 5400,
                "SAS"
            )
        );

        $flightSchedules->add(
            new \THack2015\Domain\Contexts\Aggregation\Entities\FlightSchedule($oneFlights, 120.00, "3h45m")
        );
        $flightSchedules->add(
            new \THack2015\Domain\Contexts\Aggregation\Entities\FlightSchedule($directExpensive, 180.00, "1h30m")
        );

        $hotelStays->add(
            new \THack2015\Domain\Contexts\Aggregation\Entities\HotelStay(1, "Slums Stuff 4 Poor", 100, 100, 20)
        );
        $hotelStays->add(new \THack2015\Domain\Contexts\Aggregation\Entities\HotelStay(2, "Nice & Cozy", 100, 100, 60));
        $hotelStays->add(
            new \THack2015\Domain\Contexts\Aggregation\Entities\HotelStay(3, "Good Standard", 100, 100, 100)
        );
        $hotelStays->add(
            new \THack2015\Domain\Contexts\Aggregation\Entities\HotelStay(4, "Luxury Apartments", 100, 100, 400)
        );

        $aggregationRequest = new \THack2015\Domain\Contexts\Aggregation\Aggregates\AggregationRequest(
            $flightSchedules,
            $hotelStays,
            $app['infrastructure.aggregation.aggregation_strategy']
        );

        $bestDeals = $aggregationRequest->getBestDeals();

        return new \Symfony\Component\HttpFoundation\JsonResponse($bestDeals->toArray());
    }
);

$app->run(); 
