<?php
namespace App\Domain;

class SortPriority
{
    public static function lowPriority(&$temp, $new, $columnName) : void
    {
        for ($i = 0; $i < count($temp); $i++) {
            $temp[$i][$columnName] = $temp[$i][$columnName] - 1;
        }
        $temp[0][$columnName] = $new;
    }

    public static function upPriority(&$temp, $new, $columnName) : void
    {
        for ($i = 0; $i < count($temp); $i++) {
            $temp[$i][$columnName] = $temp[$i][$columnName] + 1;
        }
        $temp[count($temp) - 1][$columnName] = $new;
    }
}
