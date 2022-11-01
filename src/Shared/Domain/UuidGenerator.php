<?php

declare(strict_types = 1);

namespace Cbase\Shared\Domain;

interface UuidGenerator
{
    public function generate(): string;
}
