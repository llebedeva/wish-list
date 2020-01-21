<?php

namespace App\Infrastructure;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Controller
{
    public function createWishAction(Request $request)
    {
        $wish = $request->request->get('wish');
        $link = $request->request->get('link');
        $description = $request->request->get('description');
        if (empty($wish) || empty($link) || empty($description)) {
            $response = new Response('', Response::HTTP_BAD_REQUEST);
        } else {
            $response = new Response();
        }
        return $response;
    }
}
