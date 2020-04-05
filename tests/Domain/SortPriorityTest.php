<?php
namespace App\Tests\Domain;

use App\Domain\SortPriority;
use PHPUnit\Framework\TestCase;

class SortPriorityTest extends TestCase
{
    private const COLUMN_NAME = 'priority';

    public function test_lowPriority()
    {
        $columnName = self::COLUMN_NAME;
        $temp = [
            [$columnName => 2],
            [$columnName => 3],
            [$columnName => 4],
            [$columnName => 5]
        ];
        $new = 5;

        SortPriority::lowPriority($temp, $new, self::COLUMN_NAME);
        $expected = [
            [$columnName => 5],
            [$columnName => 2],
            [$columnName => 3],
            [$columnName => 4]
        ];
        $this->assertEquals($expected, $temp);
    }

    public function test_upPriority()
    {
        $columnName = self::COLUMN_NAME;
        $temp = [
            [$columnName => 2],
            [$columnName => 3],
            [$columnName => 4],
            [$columnName => 5]
        ];
        $new = 2;

        SortPriority::upPriority($temp, $new, $columnName);
        $expected = [
            [$columnName => 3],
            [$columnName => 4],
            [$columnName => 5],
            [$columnName => 2]
        ];
        $this->assertEquals($expected, $temp);
    }
}
