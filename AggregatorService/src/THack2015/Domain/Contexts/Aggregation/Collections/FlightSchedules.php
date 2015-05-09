<?php


namespace THack2015\Domain\Contexts\Aggregation\Collections;

use THack2015\Domain\Contexts\Aggregation\Entities\FlightSchedule;

class FlightSchedules implements \IteratorAggregate {

    /**
     * @var FlightSchedule[]
     */
    private $values = [];

    public function add(FlightSchedule $flight) {
        $this->values[] = $flight;
    }

    public function getIterator() {
        return new \ArrayIterator($this->values);
    }

}