<?php


namespace THack2015\Domain\Contexts\Aggregation\Collections;

use THack2015\Domain\Contexts\Aggregation\Entities\Flight;

class Flights implements \IteratorAggregate {

    /**
     * @var Flight[]
     */
    private $values = [];

    public function add(Flight $flight) {
        $this->values[] = $flight;
    }

    public function getIterator() {
        return new \ArrayIterator($this->values);
    }

    public function toArray() {
        $arrayFlights = [];

        foreach($this->values as $value) {
            $arrayFlights[] = $value->toArray();
        }

        return $arrayFlights;

    }

}