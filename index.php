<?php
require 'config.php';
require SYSTEM . 'Startup.php';

use Router\Router;

$request = new Http\Request();
$response = new Http\Response();
$GLOBALS['request'] = $request;
$GLOBALS['response'] = $response;
$response->setHeader('Content-Type: text/html; charset=UTF-8');
$router = new Router($request->getUrl(), $request->getMethod());
require 'Router/Router.php';
$router->run();
$response->render();
