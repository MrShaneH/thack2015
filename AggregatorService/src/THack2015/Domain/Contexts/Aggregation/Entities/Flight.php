<?php


namespace THack2015\Domain\Contexts\Aggregation\Entities;

class Flight
{

    /**
     * @var string
     */
    private $departureAirportCode;
    /**
     * @var string
     */
    private $departureAirportName;
    /**
     * @var
     */
    private $departureAirportLongitude;
    /**
     * @var
     */
    private $departureAirportLatitude;
    /**
     * @var
     */
    private $departureTime;
    /**
     * @var
     */
    private $arrivalAirportCode;
    /**
     * @var
     */
    private $arrivalAirportName;
    /**
     * @var
     */
    private $arrivalAirportLongitude;
    /**
     * @var
     */
    private $arrivalAirportLatitude;
    /**
     * @var
     */
    private $arrivalTime;
    /**
     * @var
     */
    private $carrier;

    function __construct(
        $departureAirportCode,
        $departureAirportName,
        $departureAirportLongitude,
        $departureAirportLatitude,
        $departureTime,
        $arrivalAirportCode,
        $arrivalAirportName,
        $arrivalAirportLongitude,
        $arrivalAirportLatitude,
        $arrivalTime,
        $carrier
    ) {
        $this->departureAirportCode = $departureAirportCode;
        $this->departureAirportName = $departureAirportName;
        $this->departureAirportLongitude = $departureAirportLongitude;
        $this->departureAirportLatitude = $departureAirportLatitude;
        $this->departureTime = $departureTime;
        $this->arrivalAirportCode = $arrivalAirportCode;
        $this->arrivalAirportName = $arrivalAirportName;
        $this->arrivalAirportLongitude = $arrivalAirportLongitude;
        $this->arrivalAirportLatitude = $arrivalAirportLatitude;
        $this->arrivalTime = $arrivalTime;
        $this->carrier = $carrier;
    }

    /**
     * @return mixed
     */
    public function getDepartureAirportCode()
    {
        return $this->departureAirportCode;
    }

    /**
     * @return mixed
     */
    public function getDepartureAirportName()
    {
        return $this->departureAirportName;
    }

    /**
     * @return mixed
     */
    public function getDepartureTime()
    {
        return $this->departureTime;
    }

    /**
     * @return mixed
     */
    public function getArrivalAirportCode()
    {
        return $this->arrivalAirportCode;
    }

    /**
     * @return mixed
     */
    public function getArrivalAirportName()
    {
        return $this->arrivalAirportName;
    }

    /**
     * @return mixed
     */
    public function getDepartureAirportLongtitude()
    {
        return $this->departureAirportLongitude;
    }

    /**
     * @return mixed
     */
    public function getDepartureAirportLatitude()
    {
        return $this->departureAirportLatitude;
    }

    /**
     * @return mixed
     */
    public function getArrivalTime()
    {
        return $this->arrivalTime;
    }

    /**
     * @return mixed
     */
    public function getCarrier()
    {
        return $this->carrier;
    }

    /**
     * @return mixed
     */
    public function getDepartureAirportLongitude()
    {
        return $this->departureAirportLongitude;
    }

    /**
     * @return mixed
     */
    public function getArrivalAirportLongitude()
    {
        return $this->arrivalAirportLongitude;
    }

    /**
     * @return mixed
     */
    public function getArrivalAirportLatitude()
    {
        return $this->arrivalAirportLatitude;
    }

    public function toArray()
    {

        return [
            'departureAirportCode' => $this->departureAirportCode,
            'departureAirportName' => $this->departureAirportName,
            'departureAirportLongitude' => $this->departureAirportLongitude,
            'departureAirportLatitude' => $this->departureAirportLatitude,
            'departureTime' => $this->departureTime,
            'arrivalAirportCode' => $this->arrivalAirportCode,
            'arrivalAirportName' => $this->arrivalAirportName,
            'arrivalAirportLongitude' => $this->arrivalAirportLongitude,
            'arrivalAirportLatitude' => $this->arrivalAirportLatitude,
            'arrivalTime' => $this->arrivalTime,
            'carrier' => $this->carrier,
        ];
    }
}