<?php
namespace App\Tests\Domain;

use App\Domain\DeleteWishRequest;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class DeleteWishRequestTest extends TestCase
{
    private const ID_NAME = 'id';
    private const VALID_ID = 1;

    public function testSuccessIfVaidAgruments()
    {
        $request = new Request([], [self::ID_NAME => self::VALID_ID]);

        $request = new DeleteWishRequest($request);

        $this->assertInstanceOf(DeleteWishRequest::class, $request);
    }

    /**
     * @dataProvider providerInvalidArguments
     * @param $data
     */
    public function testThrowsExceptionIfInvalidArguments($data)
    {
        $request = new Request([], $data);

        $this->expectException(\InvalidArgumentException::class);

        new DeleteWishRequest($request);
    }

    public function providerInvalidArguments()
    {
        return [
            [[self::ID_NAME => null]],
            [[self::ID_NAME => '']],
            [[self::ID_NAME => 't']]
        ];
    }
}
