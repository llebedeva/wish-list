<?php
namespace App\Tests\Infrastructure;

use App\Tests\SetUpTestCase;
use App\Infrastructure\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ControllerTest extends SetUpTestCase
{
    public function testGetWish()
    {
        $id = 0;
        $controller = new Controller();

        /** @var Response $response */
        $response = $controller->getWish($id);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertNotEmpty($response->getContent());
    }

    public function testGetWishlist()
    {
        $controller = new Controller();

        /** @var Response $response */
        $response = $controller->getWishlist();

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
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
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
        $request = new Request([], ['wish' => 'Wish', 'link' => 'Link', 'description' => 'Description',
            'priority' => 1,'id' => 1]);
        $controller = new Controller();

        /** @var Response $response */
        $response = $controller->updateWishAction($request);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
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
        $id = 15;
        $controller = new Controller();

        /** @var Response $response */
        $response = $controller->deleteWishAction($id);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }

    public function testDeleteWish_error()
    {
        $id = 'tt';
        $controller = new Controller();

        /** @var Response $response */
        $response = $controller->deleteWishAction($id);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testChangeOrderAction_success()
    {
        $request = new Request([], ['old' => 2, 'new' => 5]);
        $controller = new Controller();

        /** @var Response $response */
        $response = $controller->changeOrderAction($request);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }

    public function testChangeOrderAction_error()
    {
        $request = new Request();
        $controller = new Controller();

        /** @var Response $response */
        $response = $controller->changeOrderAction($request);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }
}
