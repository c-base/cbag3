<?php
namespace App\Utils;

class Slugger
{
    /**
     * @param string $value
     * @return string
     */
    public function slugify(string $value): string
    {
        return str_replace(' ', '-', strtolower($value));
    }
}
