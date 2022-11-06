<?php
/*
 * (c) 2022 dazz <dazz@c-base.org>
 *
 * For copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Cbase\Shared\Domain\Utils;

final class CollectionUtils
{
    public static function map(callable $fn, iterable $collection): array
    {
        $result = [];
        foreach ($collection as $key => $value) {
            $result[$key] = $fn($value, $key);
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