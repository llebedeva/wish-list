<?php

define("PROJECT_ROOT", dirname(__DIR__));
require PROJECT_ROOT . '/vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use App\Infrastructure\Controller;


$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->get('/', function(Controller $controller) {
        return $controller->indexAction();
    });
    $r->post('/wish/create', function(Controller $controller, Request $request) {
        return $controller->addWishAction($request);
    });
    $r->put('/wish/update', function(Controller $controller, Request $request) {
        return $controller->updateWishAction($request);
    });
    $r->put('/wish/change_order', function(Controller $controller, Request $request) {
        return $controller->changeOrderAction($request);
    });
    $r->post('/wish/delete', function(Controller $controller, Request $request) {
        return $controller->deleteWishAction($request);
    });
});

$request = Request::createFromGlobals();

// Fetch method and URI from somewhere
$httpMethod = $request->getMethod();
$uri = $request->getRequestUri();

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        $handler(new Controller(), $request, $vars)->send();
        break;
}
