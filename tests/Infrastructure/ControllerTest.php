<?php

namespace App\Tests\Infrastructure;

use App\Infrastructure\Controller;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ControllerTest extends TestCase
{
    public function testIndex()
    {
        $controller = new Controller();

        /** @var Response $response */
        $response = $controller->indexAction();

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertNotEmpty($response->getContent());
    }

    public function testCreateWish_success()
    {
        $request = new Request([], ['wish' => 'Wish', 'link' => 'Link', 'description' => 'Description']);
        $controller = new Controller();

        /** @var Response $response */
        $response = $controller->createWishAction($request);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }

    public function testCreateWish_error()
    {
        $request = new Request();
        $controller = new Controller();

        /** @var Response $response */
        $response = $controller->createWishAction($request);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }
}
