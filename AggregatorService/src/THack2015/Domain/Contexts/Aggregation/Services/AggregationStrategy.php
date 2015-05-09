<?php


namespace THack2015\Domain\Contexts\Aggregation\Services;

use THack2015\Domain\Contexts\Aggregation\Collections\HotelStays;
use THack2015\Domain\Contexts\Aggregation\Collections\FlightSchedules;
use THack2015\Domain\Contexts\Aggregation\Collections\Deals;

interface AggregationStrategy
{

    /**
     * @param FlightSchedules $flightSchedules
     * @param HotelStays $hotelStays
     * @return Deals
     */
    public function getBestDeals(FlightSchedules $flightSchedules, HotelStays $hotelStays);
}