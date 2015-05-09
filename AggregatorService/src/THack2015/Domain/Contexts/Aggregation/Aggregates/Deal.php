<?php


namespace THack2015\Domain\Contexts\Aggregation\Aggregates;

use THack2015\Domain\Contexts\Aggregation\Entities\FlightSchedule;
use THack2015\Domain\Contexts\Aggregation\Entities\HotelStay;

class Deal
{

    /**
     * @var FlightSchedule
     */
    private $flightSchedule;

    /**
     * @var HotelStay
     */
    private $hotelStay;

    /**
     * @param FlightSchedule $flightSchedule
     * @param HotelStay $hotelStay
     */
    public function __construct(FlightSchedule $flightSchedule, HotelStay $hotelStay)
    {
        $this->flightSchedule = $flightSchedule;
        $this->hotelStay = $hotelStay;
    }

    public function toArray() {
        return [
            'flightSchedule' => $this->flightSchedule->toArray(),
            'hotelStay' => $this->hotelStay->toArray()
        ];
    }


}