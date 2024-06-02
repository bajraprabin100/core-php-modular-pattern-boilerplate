<?php

require_once '../core/Container.php';
require_once '../core/GoogleClient.php';
require_once '../modules/google-calender/services/implementation/GoogleCalenderService.php';
require_once '../modules/google-calender/services/interfaces/IGoogleCalenderService.php';

$container = new Container();

$container->bind(IGoogleCalenderService::class, function($container) {
    return new GoogleCalenderService(new GoogleClient());
});
$container->bind(EventController::class, function($container) {
    $googleCalenderService = $container->resolve(IGoogleCalenderService::class);
    return new EventController($googleCalenderService);
});
return $container;
?>