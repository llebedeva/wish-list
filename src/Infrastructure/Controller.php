<?php
namespace App\Infrastructure;

use App\Domain\PostDataRequest;
use App\Domain\Wish;
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

    public function addWishAction(Request $request)
    {
        try {
            $wish = new Wish(
                $request->request->get('wish'),
                $request->request->get('link'),
                $request->request->get('description')
            );
            $response = new Response();
        } catch (\Exception $e) {
            $response = new Response("Error!: " . $e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
