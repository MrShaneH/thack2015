<?php


namespace THack2015\Domain\Contexts\Aggregation\Collections;

use PHPFluent\JSONSerializer\Serializer;
use THack2015\Domain\Contexts\Aggregation\Entities\HotelStay;

class HotelStays extends Serializer implements \IteratorAggregate {


    /**
     * @PHPFluent\JSONSerializer\Attribute
     * @var HotelStay[]
     */
    private $values = [];

    public function add(HotelStay $hotelStay) {
        $this->values[] = $hotelStay;
    }

    public function getIterator() {
        return new \ArrayIterator($this->values);
    }

}