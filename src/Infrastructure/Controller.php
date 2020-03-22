<?php
namespace App\Infrastructure;

use App\Domain\CreateWishRequest;
use App\Domain\DeleteWishRequest;
use App\Domain\UpdateWishRequest;
use App\Storage\Storage;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Controller
{
    public function indexAction(Request $request)
    {
        $storage = new Storage();
        $stmt = $storage->getWishTable();

        $s = $this->render_php(PROJECT_ROOT . "/src/wishlist.php", [
            "stmt" => $stmt,
            "id" => $request->request->get('edit') ? $request->request->get('id') : null
        ]);

        $response = new Response($s);
        $response->headers->set('Content-Type', 'text/html');
        return $response;
    }

    public function addWishAction(Request $request)
    {
        try {
            $wish = $request->request->get('wish');
            $link = $request->request->get('link');
            $description = $request->request->get('description');

            new CreateWishRequest($wish, $link, $description);

            $storage = new Storage();
            $storage->createWish($wish, $link, $description);

            $response = new Response('', Response::HTTP_MOVED_PERMANENTLY);
        } catch (\Exception $e) {
            $response = new Response("Error!: " . $e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
        $response->headers->set('Location', '/');
        return $response;
    }

    public function updateWishAction(Request $request)
    {
        try {
            $wish = $request->request->get('wish');
            $link = $request->request->get('link');
            $description = $request->request->get('description');
            $id = $request->request->get('id');

            new UpdateWishRequest($wish, $link, $description, $id);

            $storage = new Storage();
            $storage->updateWish($wish, $link, $description, $id);

            $response = new Response('', Response::HTTP_MOVED_PERMANENTLY);
        } catch (\Exception $e) {
            $response = new Response("Error!: " . $e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
        $response->headers->set('Location', '/');
        return $response;
    }

    public function deleteWishAction(Request $request)
    {
        try {
            $id = $request->request->get('id');

            new DeleteWishRequest($id);

            $storage = new Storage();
            $storage->deleteWish($id);

            $response = new Response('', Response::HTTP_MOVED_PERMANENTLY);
        } catch (\Exception $e) {
            $response = new Response("Error!: " . $e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
        $response->headers->set('Location', '/');
        return $response;
    }

    private function render_php($path, array $variables)
    {
        ob_start();
        include($path);
        $var = ob_get_contents();
        ob_end_clean();
        return $var;
    }
}
