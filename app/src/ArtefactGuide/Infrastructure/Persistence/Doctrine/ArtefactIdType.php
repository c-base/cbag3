<?php

declare(strict_types=1);

namespace Cbase\ArtefactGuide\Infrastructure\Persistence\Doctrine;

use Cbase\Shared\Domain\ArtefactId;
use Cbase\Shared\Infrastructure\Persistence\Doctrine\UuidType;

final class ArtefactIdType extends UuidType
{
    public const TYPE = 'artefact_id';

    public static function customTypeName(): string
    {
        return self::TYPE;
    }

    protected function typeClassName(): string
    {
        return ArtefactId::class;
    }
}
