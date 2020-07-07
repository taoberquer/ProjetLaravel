<?php

namespace App\Helpers;

class BytesToHumanHelper
{
    public static function convert(int $bytes)
    {
        $units = ['octet(s)', 'Ko', 'Mo', 'Go', 'To', 'Po'];

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }
}
