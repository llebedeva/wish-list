<?php

namespace App\Infrastructure;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Controller
{
    public function indexAction()
    {
        $response = new Response(
            (string)file_get_contents(PROJECT_ROOT . "/src/index.html"));
        $response->headers->set('Content-Type', 'text/html');
        return $response;
    }

    public function createWishAction(Request $request)
    {
        $wish = $request->request->get('wish');
        $link = $request->request->get('link');
        $description = $request->request->get('description');
        if (empty($wish) || empty($link) || empty($description)) {
            $response = new Response('{"a":1}', Response::HTTP_BAD_REQUEST);
        } else {
            $response = new Response();
        }
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
