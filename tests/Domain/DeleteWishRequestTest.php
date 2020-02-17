<?php
namespace App\Tests\Domain;

use App\Domain\DeleteWishRequest;
use PHPUnit\Framework\TestCase;

class DeleteWishRequestTest extends TestCase
{
    private const VALID_ID = '15';

    public function testSuccessIfVaidAgruments()
    {
        $id = self::VALID_ID;

        $request = new DeleteWishRequest($id);

        $this->assertInstanceOf(DeleteWishRequest::class, $request);
    }

    public function testThrowsExceptionIfInvalidArguments()
    {
        $this->expectException(\InvalidArgumentException::class);

        new DeleteWishRequest(null);
    }
}
