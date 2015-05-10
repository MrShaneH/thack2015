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

    private $hotelName;

    private $images;

    public function __construct($hotelId, $hotelName, $locationName, $longitute, $latitude, $price, $images)
    {
        $this->hotelId = $hotelId;
        $this->hotelName = $hotelName;
        $this->locationName = $locationName;
        $this->longitude = $longitute;
        $this->latitude = $latitude;
        $this->price = $price;
        $this->images = $images;
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
            'hotelName' => $this->hotelName,
            'locationName' => $this->locationName,
            'longitude' => $this->longitude,
            'latitude' => $this->latitude,
            'price' => $this->price,
            'images' => $this->images
        ];
    }
}