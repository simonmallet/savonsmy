<?php

namespace App\Domain\Helpers;

class FormattingHelper
{
    public static function formatPrice(float $number): string
    {
        return number_format($number, 2);
    }
}
