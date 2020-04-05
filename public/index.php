<?php

define("PROJECT_ROOT", dirname(__DIR__));
require PROJECT_ROOT . '/vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use App\Infrastructure\Controller;


$request = Request::createFromGlobals();
$controller = new Controller();

if ($request->request->get('add')) {
    $response = $controller->addWishAction($request);
} elseif ($request->request->get('update')) {
    $response = $controller->updateWishAction($request);
} elseif ($request->request->get('delete')) {
    $response = $controller->deleteWishAction($request);
} elseif ($request->request->get('change_order')) {
    $response = $controller->changeOrderAction($request);
} else {
    $response = $controller->indexAction();
}
$response->send();
