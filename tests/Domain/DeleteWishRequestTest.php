<?php
namespace App\Tests\Domain;

use App\Domain\DeleteWishRequest;
use PHPUnit\Framework\TestCase;

class DeleteWishRequestTest extends TestCase
{
    private const VALID_ID = 1;

    public function testSuccessIfValidAgrument()
    {
        $request = new DeleteWishRequest(self::VALID_ID);

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
            ['s'],
            [''],
            [11.1]
        ];
    }
}
