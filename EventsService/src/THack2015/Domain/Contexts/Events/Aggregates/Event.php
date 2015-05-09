<?php


namespace THack2015\Domain\Contexts\Events\Aggregates;

/**
 *
 * Class Event
 * @package THack2015\Domain\Contexts\Events\Aggregates
 */
class Event {

    private $eventId;

    private $eventCategory;

    private $eventName;

    private $locationName;

    private $date;

    private $longitude;

    private $latitude;

    private $eventDescription;

    private $eventImages;

    function __construct(
        $eventId,
        $eventCategory,
        $eventName,
        $locationName,
        $date,
        $longitude,
        $latitude,
        $eventDescription,
        $eventImages
    ) {
        $this->eventId = $eventId;
        $this->eventCategory = $eventCategory;
        $this->eventName = $eventName;
        $this->locationName = $locationName;
        $this->date = $date;
        $this->longitude = $longitude;
        $this->latitude = $latitude;
        $this->eventDescription = $eventDescription;
        $this->eventImages = $eventImages;
    }

    public function toArray() {

        return [
            'eventId' => $this->eventId,
            'eventCategory' => $this->eventCategory,
            'eventName' => $this->eventName,
            'locationName' => $this->locationName,
            'date' => $this->date,
            'longitude'  => $this->longitude,
            'latitude' => $this->latitude,
            'eventDescription'  => $this->eventDescription,
            'eventImages' => $this->eventImages
        ];

    }
}