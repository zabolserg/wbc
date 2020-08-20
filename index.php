<?php
require_once __DIR__ . '/vendor/autoload.php';

use App\Modules;
use App\Views;
use App\Controllers\DefaultController;

Modules\Session::start();
$request = new Modules\Request();

$routing = new Modules\Routing($request);
try{
    $response = $routing->callController();
} catch (Exception $e) {
    $response = new Modules\Response(new Views\Load('404'), 404);
}
$response->send();
