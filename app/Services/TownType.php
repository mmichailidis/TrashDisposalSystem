<?php

/**
 * Created by IntelliJ IDEA.
 * User: MidoriKage
 * Date: 05-May-18
 * Time: 12:08 PM
 */
namespace App\Services;


class TownType
{
    private static $START_ROUTE = [0, 'start'];
    private static $MIDDLE_ROUTE = [1, 'middle'];
    private static $ENDING_ROUTE = [2, 'end'];

    public static function getType($val): string
    {
        switch ($val) {
            case self::$START_ROUTE[0]:
                return self::$START_ROUTE[1];
            case self::$MIDDLE_ROUTE[0]:
                return self::$MIDDLE_ROUTE[1];
            case self::$ENDING_ROUTE[0]:
                return self::$ENDING_ROUTE[1];
            default:
                return self::$MIDDLE_ROUTE[1];
        }
    }
}