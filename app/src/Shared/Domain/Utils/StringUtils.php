<?php

declare(strict_types=1);

namespace Cbase\Shared\Domain\Utils;

final class StringUtils
{
    public static function toSnakeCase(string $text): string
    {
        return ctype_lower($text) ? $text : strtolower(preg_replace('/([^A-Z\s])([A-Z])/', '$1_$2', $text));
    }

    public static function toCamelCase(string $text): string
    {
        return lcfirst(str_replace('_', '', ucwords($text, '_')));
    }

    public static function sluggify(string $text): string
    {
        $string = str_replace(['ä', 'ö', 'ü', 'ß'], ['ae', 'oe', 'ue', 'ss'], strtolower($text));
        $string = preg_replace('#[^a-z0-9]+#i', '-', $string);
        return trim($string, '-');
    }
}
