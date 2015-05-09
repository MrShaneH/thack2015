<?php


namespace THack2015\Domain\Contexts\Aggregation\Aggregates;

use THack2015\Domain\Contexts\Aggregation\Collections\FlightSchedules;
use THack2015\Domain\Contexts\Aggregation\Collections\HotelStays;
use THack2015\Domain\Contexts\Aggregation\Services\AggregationStrategy;

/**
 * Class AggregationRequest
 * @package THack2015\Domain\Contexts\Aggregation\Aggregates
 */
class AggregationRequest
{

    /**
     * @var FlightSchedules
     */
    private $flightSchedules;

    /**
     * @var HotelStays
     */
    private $hotelStays;

    /**
     * @var AggregationStrategy
     */
    private $aggregationStrategy;

    /**
     * @param $flightSchedules
     * @param $hotelStays
     * @param AggregationStrategy $aggregationStrategy
     */
    public function __construct($flightSchedules, $hotelStays, AggregationStrategy $aggregationStrategy)
    {
        $this->flightSchedules = $flightSchedules;
        $this->hotelStays = $hotelStays;
        $this->aggregationStrategy = $aggregationStrategy;
    }

    public function getBestDeals()
    {
        return $this->aggregationStrategy->getBestDeals($this->flightSchedules, $this->hotelStays);
    }
}