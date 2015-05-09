<?php
require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

$app['infrastructure.aggregation.aggregation_strategy'] = new \THack2015\Infrastructure\Contexts\Aggregation\AggregationStrategy\PriceAggregationStrategy();


$app['infrastructure.aggregation.aggregation_request_factory'] = new \THack2015\Infrastructure\Contexts\Aggregation\RequestConverter\AggregationRequestFactory();
$app['infrastructure.aggregation.aggregation_strategy_factory'] = new \THack2015\Infrastructure\Contexts\Aggregation\RequestConverter\AggregationStrategyFactory();

return $app;