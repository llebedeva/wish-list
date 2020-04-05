<?php
namespace App\Tests\Domain;

use App\Domain\ChangeOrderRequest;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class ChangeOrderRequestTest extends TestCase
{
    private const OLD_NAME = 'old';
    private const NEW_NAME = 'new';
    private const VALID_VALUE = 1;

    /**
     * @dataProvider providerValidArguments
     * @param $old
     * @param $new
     */
    public function testValidArguments($old, $new)
    {
        $request = new Request([], [self::OLD_NAME => $old, self::NEW_NAME => $new]);
        $request = new ChangeOrderRequest($request);

        $this->assertInstanceOf(ChangeOrderRequest::class, $request);
    }

    public function providerValidArguments()
    {
        return [
            [1, 4],
            [5, 0],
            ['1', '2']
        ];
    }

    /**
     * @dataProvider providerInvalidArguments
     * @param $old
     * @param $new
     */
    public function testThrowsExceptionIfInvalidArguments($old, $new)
    {
        $request = new Request([], [self::OLD_NAME => $old, self::NEW_NAME => $new]);
        $this->expectException(\InvalidArgumentException::class);

        new ChangeOrderRequest($request);
    }

    public function providerInvalidArguments()
    {
        return [
            ['t', self::VALID_VALUE],
            [self::VALID_VALUE, 't'],
            [null, self::VALID_VALUE],
            [self::VALID_VALUE, null],
            [self::VALID_VALUE, self::VALID_VALUE]
        ];
    }
}
