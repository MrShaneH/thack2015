<?php
require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();
$app['infrastructure.events.eventful_api_key'] = "HZzh336SSXWHZjpV";
$app['infrastructure.cache'] = new \THack2015\Infrastructure\Cache\CacheAccess();
$app['infrastructure.events.event_repository'] = new \THack2015\Infrastructure\Contexts\Events\Repository\EventfulApiEventRepository($app['infrastructure.cache'],$app['infrastructure.events.eventful_api_key']);

return $app;