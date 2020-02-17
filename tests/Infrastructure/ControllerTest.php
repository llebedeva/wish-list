<?php
namespace App\Tests\Infrastructure;

use App\Tests\SetUpTestCase;
use App\Infrastructure\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ControllerTest extends SetUpTestCase
{
    public function testIndex()
    {
        $request = new Request();
        $controller = new Controller();

        /** @var Response $response */
        $response = $controller->indexAction($request);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertNotEmpty($response->getContent());
    }

    public function testAddWish_success()
    {
        $request = new Request([], ['wish' => 'Wish', 'link' => 'Link', 'description' => 'Description']);
        $controller = new Controller();

        /** @var Response $response */
        $response = $controller->addWishAction($request);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(Response::HTTP_MOVED_PERMANENTLY, $response->getStatusCode());
    }

    public function testAddWish_error()
    {
        $request = new Request();
        $controller = new Controller();

        /** @var Response $response */
        $response = $controller->addWishAction($request);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testUpdateWish_success()
    {
        $request = new Request([], ['wish' => 'Wish', 'link' => 'Link', 'description' => 'Description', 'id' => 'id']);
        $controller = new Controller();

        /** @var Response $response */
        $response = $controller->updateWishAction($request);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(Response::HTTP_MOVED_PERMANENTLY, $response->getStatusCode());
    }

    public function testUpdateWish_error()
    {
        $request = new Request();
        $controller = new Controller();

        /** @var Response $response */
        $response = $controller->updateWishAction($request);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testDeleteWish_success()
    {
        $request = new Request([], ['wish' => '', 'link' => '', 'description' => '', 'id' => '15']);
        $controller = new Controller();

        /** @var Response $response */
        $response = $controller->deleteWishAction($request);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(Response::HTTP_MOVED_PERMANENTLY, $response->getStatusCode());
    }

    public function testDeleteWish_error()
    {
        $request = new Request();
        $controller = new Controller();

        /** @var Response $response */
        $response = $controller->deleteWishAction($request);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }
}
