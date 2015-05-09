<?php
require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

$app['infrastructure.aggregation.aggregation_strategy'] = new \THack2015\Infrastructure\Contexts\Aggregation\AggregationStrategy\DummyAggregationStrategy();


$app['infrastructure.aggregation.aggregation_request_factory'] = new \THack2015\Infrastructure\Contexts\Aggregation\RequestConverter\AggregationRequestFactory($app['infrastructure.aggregation.aggregation_strategy']);

return $app;