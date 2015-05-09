<?php


namespace THack2015\Infrastructure\Contexts\Aggregation\RequestConverter;

use Symfony\Component\HttpFoundation\Request;
use THack2015\Infrastructure\Contexts\Aggregation\AggregationStrategy\ConvenienceAggregationStrategy;
use THack2015\Infrastructure\Contexts\Aggregation\AggregationStrategy\PriceAggregationStrategy;

class AggregationStrategyFactory
{

    public function create(Request $request)
    {

        $strategyType = $request->get('strategy', null);

        switch ($strategyType) {

            case "convenience": {
                return new ConvenienceAggregationStrategy();
            }

            default: {
                return new PriceAggregationStrategy();
            }
        }
    }
}