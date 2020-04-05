<?php
namespace App\Tests\Domain;

use App\Domain\ChangeOrderRequest;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class ChangeOrderRequestTest extends TestCase
{
    private const OLD_NAME = 'old';
    private const NEW_NAME = 'new';
    private const CORRECT_VALUE = 1;

    /**
     * @dataProvider providerValidArguments
     * @param $data
     */
    public function testValidArguments($data)
    {
        $request = new Request([], $data);
        $request = new ChangeOrderRequest($request);

        $this->assertInstanceOf(ChangeOrderRequest::class, $request);
    }

    public function providerValidArguments()
    {
        return [
            [[self::OLD_NAME => 1, self::NEW_NAME => 4]],
            [[self::OLD_NAME => 5, self::NEW_NAME => 0]],
            [[self::OLD_NAME => '1', self::NEW_NAME => '2']]
        ];
    }

    /**
     * @dataProvider providerInvalidArguments
     * @param $data
     */
    public function testThrowsExceptionIfInvalidArguments($data)
    {
        $request = new Request([], $data);
        $this->expectException(\InvalidArgumentException::class);

        new ChangeOrderRequest($request);
    }

    public function providerInvalidArguments()
    {
        return [
            [[self::OLD_NAME => 'r',                     self::NEW_NAME => self::CORRECT_VALUE]],
            [[self::OLD_NAME => self::CORRECT_VALUE,     self::NEW_NAME => 't'                ]],
            [[self::OLD_NAME => self::CORRECT_VALUE,     self::NEW_NAME => null               ]],
            [[self::OLD_NAME => null,                    self::NEW_NAME => self::CORRECT_VALUE]],
            [[self::OLD_NAME => self::CORRECT_VALUE,     self::NEW_NAME => self::CORRECT_VALUE]]
        ];
    }
}
