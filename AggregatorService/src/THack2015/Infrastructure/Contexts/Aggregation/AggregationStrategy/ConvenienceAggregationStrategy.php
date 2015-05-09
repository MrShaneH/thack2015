<?php


namespace THack2015\Infrastructure\Contexts\Aggregation\AggregationStrategy;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use THack2015\Domain\Contexts\Aggregation\Aggregates\AggregationRequest;
use THack2015\Domain\Contexts\Aggregation\Collections\Deals;
use THack2015\Domain\Contexts\Aggregation\Collections\Flights;
use THack2015\Domain\Contexts\Aggregation\Collections\FlightSchedules;
use THack2015\Domain\Contexts\Aggregation\Collections\HotelStays;
use THack2015\Domain\Contexts\Aggregation\Entities\Flight;
use THack2015\Domain\Contexts\Aggregation\Entities\FlightSchedule;
use THack2015\Domain\Contexts\Aggregation\Entities\HotelStay;
use THack2015\Domain\Contexts\Aggregation\Services\AggregationStrategy;
use THack2015\Domain\Contexts\Aggregation\Aggregates\Deal;

class ConvenienceAggregationStrategy implements AggregationStrategy
{

    /**
     * @param FlightSchedules $flightSchedules
     * @param HotelStays $hotelStays
     * @return Deal
     */
    public function getBestDeals(FlightSchedules $flightSchedules, HotelStays $hotelStays) {

        $if = $flightSchedules->getIterator();
        $ih = $hotelStays->getIterator();

        $deals = new Deals();
        for($f = 0; $f < $if->count(); ++$f) {
            for($h = 0; $h < $ih->count(); ++$h) {
                $deals->add(new Deal($if->offsetGet($f), $ih->offsetGet($h)));
            }
        }

        return $deals;

    }


}