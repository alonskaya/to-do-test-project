<?php

use App\Service\Initializer\RoutesInitializer;
use Klein\Klein;
use Klein\Request;

require_once __DIR__ . '/../vendor/autoload.php';


if (isset($_ENV['ENV']) && $_ENV['ENV'] === 'dev') {
    ini_set('display_errors', 'On');
    set_error_handler('var_dump');
    error_reporting(E_ALL);
}

session_start();

$klein   = new Klein();
$request = Request::createFromGlobals();

// Init global lazy-loading services
$services = (include __DIR__ . '/../config/services.php');

foreach ($services as $serviceName => $serviceClass) {
    $klein->app()->register($serviceName, call_user_func([$serviceClass, 'initService'], $klein));
}

// Init routes
RoutesInitializer::init($klein);

$klein->dispatch($request);
