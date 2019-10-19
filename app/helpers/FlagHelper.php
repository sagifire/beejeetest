<?php

namespace app\helpers;

/**
 * Класс для работы с побитовыми флагами
 * Class FlagHelper
 *
 * @package app\helpers
 */
class FlagHelper
{
    /**
     * Получает массив флагов и флаг который нужно установить в 1
     *
     * @param $flags
     * @param $flag
     *
     * @return mixed
     */
    public static function on($flags, $flag)
    {
        $flags |= $flag;

        return $flags;
    }

    /**
     * Получает массив флагов и флаг который нужно установить в 0
     *
     * @param $flags
     * @param $flag
     *
     * @return mixed
     */
    public static function off($flags, $flag)
    {
        $flags &= ~$flag;

        return $flags;
    }

    /**
     * Получает массив флагов и флаг который нужно перевернуть
     * если флаг  `0` то станет `1` если `1` то станет ’0’
     *
     * @param $flags
     * @param $flag
     *
     * @return mixed
     */
    public static function flip($flags, $flag)
    {
        $flags ^= $flag;

        return $flags;
    }

    /**
     * Получает массив флагов и флаг который нужно проверить
     *
     * @param $flags
     * @param $flag
     *
     * @return bool
     */
    public static function test($flags, $flag)
    {
        return ($flags & $flag) == $flag;
    }
}