<?php

declare(strict_types=1);

namespace Cbase\Shared\Domain\Contract;

trait UuidCreatable
{
    public static function create(?string $value = null): self
    {
        return new self($value ?? static::random()->value());
    }
}
