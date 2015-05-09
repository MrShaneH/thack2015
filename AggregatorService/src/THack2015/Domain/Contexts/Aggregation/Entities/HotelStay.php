<?php


namespace THack2015\Domain\Contexts\Aggregation\Entities;

/**
 * Class HotelStay
 * @package THack2015\Domain\Contexts\Aggregation\Entities
 */
class HotelStay
{

    private $hotelId;

    private $locationName;

    private $longitude;

    private $latitude;

    private $price;

    public function __construct($hotelId, $locationName, $longitute, $latitude, $price)
    {
        $this->hotelId = $hotelId;
        $this->locationName = $locationName;
        $this->longitude = $longitute;
        $this->latitude = $latitude;
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getHotelId()
    {
        return $this->hotelId;
    }

    /**
     * @return mixed
     */
    public function getLocationName()
    {
        return $this->locationName;
    }

    /**
     * @return mixed
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @return mixed
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    public function toArray()
    {
        return [
            'hotelId' => $this->hotelId,
            'locationName' => $this->locationName,
            'longitude' => $this->longitude,
            'latitude' => $this->latitude,
            'price' => $this->price
        ];
    }
}