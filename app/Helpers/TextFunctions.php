<?php

namespace App\Helpers;

// Pattern Factory | SOLID | DTO

class TextFunctions extends HelperFunctions
{
    public function stripTags($text)
    {
        return strip_tags($text);
    }

    public function removeSpaces($text)
    {
        return str_replace(' ', '', $text);
    }

    public function replaceSpacesToEol($text)
    {
        return str_replace(' ', PHP_EOL, $text);
    }

    public function htmlspecialchars($text)
    {
        return htmlspecialchars($text);
    }

    public function removeSymbols($text)
    {
        return str_replace(['.', ',', '/', '!', '@', '#', '$', '%', '^', '&', '*', '(', ')'], '', $text);
    }

    public function toNumber($text)
    {
        preg_match('/\d+/', $text, $number);
        return $number[0] ?? 0;
    }
}
