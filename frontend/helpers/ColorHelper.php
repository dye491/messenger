<?php

namespace frontend\helpers;

class ColorHelper
{
    public static function color($id)
    {
        $angle = 15 * ($id % 12);
        return "hsl($angle, 70%, 50%)";
    }
}