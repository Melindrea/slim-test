<?php

namespace Lees\Library;

class Arr
{
    public static function get($array, $key, $default = null)
    {
        if (isset($array[$key])) {
            return $array[$key];
        }

        return $default;
    }
}
