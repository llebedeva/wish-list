<?php
namespace App\Tests\Domain;

use App\Domain\DeleteWishRequest;
use PHPUnit\Framework\TestCase;

class DeleteWishRequestTest extends TestCase
{
    private const VALID_ID = 1;

    public function testSuccessIfVaidAgruments()
    {
        $id = self::VALID_ID;

        $request = new DeleteWishRequest($id);

        $this->assertInstanceOf(DeleteWishRequest::class, $request);
    }

    /**
     * @dataProvider providerInvalidArguments
     * @param $id
     */
    public function testThrowsExceptionIfInvalidArguments($id)
    {
        $this->expectException(\InvalidArgumentException::class);

        new DeleteWishRequest($id);
    }

    public function providerInvalidArguments()
    {
        return [
            [null],
            ['']
        ];
    }
}
