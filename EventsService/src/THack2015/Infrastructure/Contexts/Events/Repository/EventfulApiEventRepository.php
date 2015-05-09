<?php


namespace THack2015\Infrastructure\Contexts\Events\Repository;


use GuzzleHttp\Client;
use THack2015\Domain\Contexts\Events\Collections\Events;
use THack2015\Domain\Contexts\Events\Aggregates\Event;
use THack2015\Domain\Contexts\Events\Repository\EventRepository;
use THack2015\Infrastructure\Cache\CacheAccess;

class EventfulApiEventRepository implements EventRepository {

    private $eventApiKey;

    private $cacheAccess;

    private $client;

    public function __construct(CacheAccess $cacheAccess, $eventApiKey) {
        $this->cacheAccess = $cacheAccess;
        $this->eventApiKey = $eventApiKey;
        $this->client = new Client();
    }

    public function findForInput($input) {

        $data = $this->cacheAccess->get(trim($input));

        if(!$data) {

            $data = $this->client->get("http://api.eventful.com/rest/events/search?app_key=".$this->eventApiKey."&date=Future&keywords=".$input);

            $contents = $data->getBody()->getContents();

            $xml = @simplexml_load_string($contents);
            $events = $xml->events->event;
            $eventsData = new Events();

            foreach($events as $event) {

                $images = [];

                if(property_exists($event->image,"url")) {
                    $images[] = preg_replace("#images/.*?/#","images/large/",$event->image->url);
                }



                $eventsData->add(new Event(
                    (string)$event['id'],
                    $input,
                    (string)$event->title,
                    (string)$event->city_name,
                    (string)$event->start_time,
                    (string)$event->longitude,
                    (string)$event->latitude,
                    (string)$event->description,
                    $images
                ));


            }

            $this->cacheAccess->set(trim($input), $eventsData);

        }

        return $eventsData;

    }


}