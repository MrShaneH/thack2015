<?php


namespace THack2015\Domain\Contexts\Flights\Collections;

use THack2015\Domain\Contexts\Flights\Aggregates\FlightSchedule;

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

    public function toArray() {
        $data = [];

        foreach($this->values as $value) {
            $data[] = $value->toArray();
        }

        return $data;
    }

}