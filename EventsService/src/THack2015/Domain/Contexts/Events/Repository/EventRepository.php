<?php


namespace THack2015\Domain\Contexts\Events\Repository;
use THack2015\Domain\Contexts\Events\Aggregates\Event;

interface EventRepository {

    /**
     * @param $input
     * @return Event[]
     */
    public function findForInput($input);

}