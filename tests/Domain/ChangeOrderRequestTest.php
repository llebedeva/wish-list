<?php
namespace App\Tests\Domain;

use App\Domain\ChangeOrderRequest;
use PHPUnit\Framework\TestCase;

class ChangeOrderRequestTest extends TestCase
{
    /**
     * @dataProvider providerValidArguments
     * @param $old
     * @param $new
     */
    public function testValidArguments($old, $new)
    {
        $request = new ChangeOrderRequest($old, $new);

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
        $this->expectException(\InvalidArgumentException::class);

        new ChangeOrderRequest($old, $new);
    }

    public function providerInvalidArguments()
    {
        return [
            ['r', 4],
            [5, 't'],
            [1, null],
            [null, 1],
            [5, 5]
        ];
    }
}
