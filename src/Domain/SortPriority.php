<?php
namespace App\Domain;

class SortPriority
{
    private const COLUMN_NAME = 'priority';

    public static function putIndexToBottom(&$temp, $index) : void
    {
        for ($i = 0; $i < count($temp); $i++) {
            $temp[$i][self::COLUMN_NAME] = $temp[$i][self::COLUMN_NAME] - 1;
        }
        $temp[0][self::COLUMN_NAME] = $index;
    }

    public static function putIndexToTop(&$temp, $index) : void
    {
        for ($i = 0; $i < count($temp); $i++) {
            $temp[$i][self::COLUMN_NAME] = $temp[$i][self::COLUMN_NAME] + 1;
        }
        $temp[count($temp) - 1][self::COLUMN_NAME] = $index;
    }

    public static function moveUpAllIndexesByOneStep(&$temp) : void
    {
        for ($i = 0; $i < count($temp); $i++) {
            $temp[$i][self::COLUMN_NAME] = $temp[$i][self::COLUMN_NAME] - 1;
        }
    }
}
