<?php


namespace THack2015\Domain\Contexts\Aggregation\Entities;

use PHPFluent\JSONSerializer\Serializer;
use THack2015\Domain\Contexts\Aggregation\Collections\Flights;

/**
 * Class FlightSchedule
 * @package THack2015\Domain\Contexts\Aggregation\Entities
 */
class FlightSchedule {

    /**
     * @var Flights
     */
    private $flights;

    /**
     * @var int
     */
    private $totalPrice;

    /**
     * @var int
     */
    private $totalTime;


    function __construct(Flights $flights, $totalPrice, $totalTime)
    {
        $this->flights = $flights;
        $this->totalPrice = $totalPrice;
        $this->totalTime = $totalTime;
    }

    public function toArray() {
        return [
            'flight' => $this->flights->toArray(),
            'totalPrice' => $this->totalPrice,
            'totalTime' => $this->totalTime
        ];
    }

}