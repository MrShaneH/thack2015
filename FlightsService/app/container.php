<?php
require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();
$app['infrastructure.flights.skyscanner_api_key'] = "ilw18275648197427228911861507832";
$app['infrastructure.flights.flight_repository'] = new \THack2015\Infrastructure\Contexts\Flights\Repository\SkyscannerFlightsRepository($app['infrastructure.flights.skyscanner_api_key']);

return $app;
