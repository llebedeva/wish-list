<?php

define("PROJECT_ROOT", dirname(__DIR__));
require PROJECT_ROOT . '/vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use App\Infrastructure\Controller;


$request = Request::createFromGlobals();
$controller = new Controller();

if (isset($_POST['add'])) {
    $response = $controller->addWishAction($request);
} elseif (isset($_POST['update'])) {
    $response = $controller->updateWishAction($request);
} elseif (isset($_POST['delete'])) {
    $response = $controller->deleteWishAction($request);
} elseif (isset($_POST['edit'])) {
    $response = $controller->editWishAction($request);
} else {
    $response = $controller->indexAction();
}
$response->send();
