<?php
namespace App\Infrastructure;

use App\Domain\ChangeOrderRequest;
use App\Domain\CreateWishRequest;
use App\Domain\UpdateWishRequest;
use App\Domain\DeleteWishRequest;
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

    public function indexAction() : Response
    {
        echo file_get_contents(PROJECT_ROOT . "/public/html/home.html");
        $response = new Response();
        $response->headers->set('Content-Type', 'text/html');
        return $response;
    }

    public function wishPage() : Response
    {
        $s = $this->render_php(PROJECT_ROOT . "/public/html/wish.html");

        $response = new Response($s);
        $response->headers->set('Content-Type', 'text/html');
        return $response;
    }

    public function getWish($id) : Response
    {
        $arr = json_encode($this->storage->getWish($id));
        $response = new Response($arr);
        $response->headers->set('Content-Type', 'text/html');
        return $response;
    }

    public function getWishlist() : Response
    {
        $arr = json_encode($this->storage->getWishTable());

        $response = new Response($arr);
        $response->headers->set('Content-Type', 'text/html');
        return $response;
    }

    public function addWishAction(Request $request) : Response
    {
        try {
            $request = new CreateWishRequest($request);

            $id = $this->storage->createWish(
                $request->wish(),
                $request->link(),
                $request->description());

            $response = new Response(json_encode(['id' => $id]), Response::HTTP_OK);
        } catch (\Exception $e) {
            $response = new Response("Error!: " . $e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
        return $response;
    }

    public function updateWishAction(Request $request) : Response
    {
        try {
            $request = new UpdateWishRequest($request);

            $this->storage->updateWish(
                $request->wish(),
                $request->link(),
                $request->description(),
                $request->id());

            $response = new Response('', Response::HTTP_OK);
        } catch (\Exception $e) {
            $response = new Response("Error!: " . $e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
        return $response;
    }

    public function deleteWishAction($id) : Response
    {
        try {
            $request = new DeleteWishRequest($id);

            $this->storage->deleteWish($request->id());

            $response = new Response('', Response::HTTP_OK);
        } catch (\Exception $e) {
            $response = new Response("Error!: " . $e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
        return $response;
    }

    public function changeOrderAction(Request $request) : Response
    {
        try {
            $request = new ChangeOrderRequest($request);

            $this->storage->updateWishOrder(
                $request->old(),
                $request->new());

            $response = new Response('', Response::HTTP_OK);
        } catch (\Exception $e) {
            $response = new Response("Error!: " . $e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
        return $response;
    }

    private function render_php($path, array $variables = [])
    {
        ob_start();
        include($path);
        $var = ob_get_contents();
        ob_end_clean();
        return $var;
    }
}
