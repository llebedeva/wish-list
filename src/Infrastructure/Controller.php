<?php
namespace App\Infrastructure;

use App\Domain\Wish;
use App\Storage\Storage;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Controller
{
    public function indexAction()
    {
        $storage = new Storage();
        $stmt = $storage->getWishTable();

        $s = $this->render_php(PROJECT_ROOT . "/src/wishlist.php", ["stmt"=>$stmt]);
        $response = new Response($s);
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
            $wish->validate();
            $wish->saveToStorage();
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
            $wish = new Wish(
                $request->request->get('wish'),
                $request->request->get('link'),
                $request->request->get('description'),
                $request->request->get('hidden')
            );
            $wish->validate();
            $wish->updateInStorage();
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
            $wish = new Wish(
                $request->request->get('wish'),
                $request->request->get('link'),
                $request->request->get('description'),
                $request->request->get('hidden')
            );
            $wish->isIdNotNull();
            $wish->deleteFromStorage();
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
