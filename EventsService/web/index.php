<?php

require_once __DIR__ . '/../vendor/autoload.php';

/**
 * @var Silex\Application $app
 */
$app = include(__DIR__ . '/../app/container.php');

$app->get(
    '/getEvents/{input}',
    function (\Symfony\Component\HttpFoundation\Request $request) use ($app) {
        $eventRepository = $app['infrastructure.events.event_repository'];

        $input = $request->get('input', null);

        if(!$input) {
            throw new \Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
        }

        /**
         * @var \THack2015\Infrastructure\Contexts\Events\Repository\EventfulApiEventRepository $eventRepository
         */
        $events = $eventRepository->findForInput($input);

        return new \Symfony\Component\HttpFoundation\JsonResponse($events->toArray());
    }
);

$app->run(); 
