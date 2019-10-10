<?php

namespace App\Helpers;

class TextFunctions
{
    public static function stripTags($text) {
        return strip_tags($text);
    }

    public static function removeSpaces($text) {
        return str_replace(' ', '', $text);
    }

    public static function replaceSpacesToEol($text) {
        return str_replace(' ', PHP_EOL, $text);
    }

    public static function htmlspecialchars($text) {
        return htmlspecialchars($text);
    }

    public static function removeSymbols($text) {
        return str_replace(['.', ',', '/', '!', '@', '#', '$', '%', '^', '&', '*', '(', ')'], '', $text);
    }

    public static function toNumber($text) {
        preg_match('/\d+/', $text, $number);
        return $number[0] ?? 0;
    }
}
