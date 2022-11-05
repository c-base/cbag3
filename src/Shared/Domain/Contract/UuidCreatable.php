<?php
/*
 * (c) 2022 dazz <dazz@c-base.org>
 *
 * For copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Shared\Domain\Contract;

trait UuidCreatable
{
    public static function create(?string $value = null): self
    {
        return new self($value ?? static::random()->value());
    }
}
