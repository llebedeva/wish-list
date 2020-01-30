<?php

namespace App\Infrastructure;

use App\Domain\PostDataRequest;
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
        $request = new PostDataRequest($wish, $link, $description);
        try {
            $request->validate();
            // domain logic
            $response = new Response();
        } catch (\Exception $e) {
            $response = new Response("Error!: " . $e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
