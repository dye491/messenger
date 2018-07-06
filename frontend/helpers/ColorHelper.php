<?php

namespace frontend\helpers;

class ColorHelper
{
    public static function color($id)
    {
        $angle = 22.5 * ($id % 16);
        return "hsl($angle, 70%, 50%)";
    }
}