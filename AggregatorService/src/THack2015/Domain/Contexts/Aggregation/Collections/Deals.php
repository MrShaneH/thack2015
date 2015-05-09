<?php


namespace THack2015\Domain\Contexts\Aggregation\Collections;

use THack2015\Domain\Contexts\Aggregation\Aggregates\Deal;

class Deals implements \IteratorAggregate
{

    /**
     * @var Deal[]
     */
    private $values = [];

    public function add(Deal $deal)
    {
        $this->values[] = $deal;
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->values);
    }

    public function uasort(\Closure $closure)
    {
        return uasort($this->values, $closure);
    }

    public function toArray()
    {
        $arrayDeals = [];

        foreach ($this->values as $value) {
            $arrayDeals[] = $value->toArray();
        }

        return $arrayDeals;
    }
}