<?php

define("PROJECT_ROOT", dirname(__DIR__));
require PROJECT_ROOT . '/vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use App\Infrastructure\Controller;


$request = Request::createFromGlobals();
$controller = new Controller();

if ($request->isMethod('GET')) {
    $response = $controller->indexAction();
} else {
    $response = $controller->createWishAction($request);
}
$response->send();
