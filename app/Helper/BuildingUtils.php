<?php

namespace App\Helper;

class BuildingUtils
{
    public static function formatPrice($price, $decimals = 0, $decimalSeparator = '.', $thousandsSeparator = ',')
    {
        return number_format((float)$price, $decimals, $decimalSeparator, $thousandsSeparator);
    }
}
