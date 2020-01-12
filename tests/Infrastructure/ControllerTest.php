<?php

namespace App\Tests\Infrastructure;

use App\Infrastructure\Controller;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ControllerTest extends TestCase
{
    public function testCreateWish_success()
    {
        $request = new Request();
        $controller = new Controller($request);

        /** @var Response $response */
        $response = $controller->createWishAction();

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }

    public function testCreateWish_error()
    {
        //
    }
}
