<?php

declare(strict_types=1);

namespace Cbase\Shared\Infrastructure\Persistence\Doctrine\Dbal;

interface DoctrineCustomType
{
    public static function customTypeName(): string;
}
