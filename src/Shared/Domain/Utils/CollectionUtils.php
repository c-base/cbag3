<?php

declare(strict_types=1);

namespace Cbase\Shared\Domain\Utils;

final class CollectionUtils
{
    public static function map(iterable $collection, callable $function): array
    {
        $result = [];
        foreach ($collection as $key => $value) {
            $result[$key] = $function($value, $key);
        }
        return $result;
    }

    public static function keyBy(iterable $collection, callable $function): array
    {
        $result = [];
        foreach ($collection as $key => $value) {
            $result[$function($value, $key)] = $value;
        }
        return $result;
    }
}
