<?php


namespace THack2015\Domain\Contexts\Events\Collections;


use THack2015\Domain\Contexts\Events\Aggregates\Event;
use Traversable;

class Events implements \IteratorAggregate {

    /**
     * @var Event[]
     */
    private $values;

    public function add(Event $event) {
        $this->values[] = $event;
    }

    public function toArray() {

        $data = [];

        foreach($this->values as $value) {
            $data[] = $value->toArray();
        }

        return $data;

    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Retrieve an external iterator
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->values);
    }
}