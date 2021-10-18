<?php

namespace App\Domain\Helpers;

class FormattingHelper
{
    public static function formatPrice(?float $number = 0.00): string
    {
        return number_format($number, 2);
    }
}
