<?php

require_once '../core/Router.php';
require_once '../core/Helpers.php';

$router = new Router();

$router->get('/', 'event@EventController@index');
$router->get('/event/create', 'event@EventController@create');
$router->get('/events/calender','event@EventController@calenderEvents');
$router->post('/event', 'event@EventController@store');
$router->delete('/events/{id}', 'event@EventController@delete');


$router->post('/event/store', 'event@EventController@store');

$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

$router->dispatch($url, $method);

?>