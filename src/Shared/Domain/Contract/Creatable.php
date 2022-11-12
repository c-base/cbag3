<?php
declare(strict_types=1);

namespace Cbase\Shared\Domain\Contract;

trait Creatable
{
    public static function create(...$args): static
    {
        return new static(...$args);
    }
}
