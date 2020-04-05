<?php
namespace App\Tests\Domain;

use App\Domain\SortPriority;
use PHPUnit\Framework\TestCase;

class SortPriorityTest extends TestCase
{
    private const COLUMN_NAME = 'priority';

    public function testPutIndexToBottom()
    {
        $columnName = self::COLUMN_NAME;
        $temp = [
            [$columnName => 2],
            [$columnName => 3],
            [$columnName => 4],
            [$columnName => 5]
        ];
        $new = 5;

        SortPriority::putIndexToBottom($temp, $new);
        $expected = [
            [$columnName => 5],
            [$columnName => 2],
            [$columnName => 3],
            [$columnName => 4]
        ];
        $this->assertEquals($expected, $temp);
    }

    public function testPutIndexToTop()
    {
        $columnName = self::COLUMN_NAME;
        $temp = [
            [$columnName => 2],
            [$columnName => 3],
            [$columnName => 4],
            [$columnName => 5]
        ];
        $new = 2;

        SortPriority::putIndexToTop($temp, $new);
        $expected = [
            [$columnName => 3],
            [$columnName => 4],
            [$columnName => 5],
            [$columnName => 2]
        ];
        $this->assertEquals($expected, $temp);
    }
}
