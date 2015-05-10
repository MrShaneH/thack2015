<?php
require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();
$app['infrastructure.search.events_api_domain'] = "events.eventspi.re";
$app['infrastructure.search.flights_api_domain'] = "flights.eventspi.re";
$app['infrastructure.search.hotels_api_domain'] = "api.eventspi.re";
$app['infrastructure.search.aggregator_api_domain'] = "aggregator.eventspi.re";
return $app;