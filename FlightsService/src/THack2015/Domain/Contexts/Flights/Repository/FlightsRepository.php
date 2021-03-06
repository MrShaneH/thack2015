<?php


namespace THack2015\Domain\Contexts\Flights\Repository;

use THack2015\Domain\Contexts\Flights\Collections\FlightSchedules;

interface FlightsRepository
{

    /**
     * @param $longitude
     * @param $latitude
     * @param \DateTime $arrivalTime
     * @param $destinationAirport
     * @param $dlo
     * @param $dla
     * @return FlightSchedules
     */
    public function findForPointAndTime(
        $longitude,
        $latitude,
        \DateTime $arrivalTime,
        $destinationLongitude,
        $destinationLatitude
    );
}