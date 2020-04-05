<?php
namespace App\Infrastructure;

use App\Domain\ChangeOrderRequest;
use App\Domain\CreateWishRequest;
use App\Domain\DeleteWishRequest;
use App\Domain\UpdateWishRequest;
use App\Storage\Storage;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Controller
{
    private $storage;

    /**
     * @codeCoverageIgnore
     * (StorageTest)
     */
    public function __construct()
    {
        try {
            $this->storage = new Storage();
        } catch (\Exception $e) {
            print("Error!: " . $e->getMessage());
        }
    }

    public function indexAction()
    {
        $stmt = $this->storage->getWishTable();

        $s = $this->render_php(PROJECT_ROOT . "/src/wishlist.php", [
            "stmt" => $stmt
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

            $this->storage->createWish($wish, $link, $description);

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

            new UpdateWishRequest($wish, $link, $description);

            $this->storage->updateWish($wish, $link, $description, $id);

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
            $request = new DeleteWishRequest($request);

            $this->storage->deleteWish($request->id());

            $response = new Response('', Response::HTTP_MOVED_PERMANENTLY);
        } catch (\Exception $e) {
            $response = new Response("Error!: " . $e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
        $response->headers->set('Location', '/');
        return $response;
    }

    public function changeOrderAction(Request $request)
    {
        try {
            $request = new ChangeOrderRequest($request);

            $this->storage->updateWishOrder($request->old(), $request->new());

            $response = new Response('', Response::HTTP_OK);
        } catch (\Exception $e) {
            $response = new Response("Error!: " . $e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
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
