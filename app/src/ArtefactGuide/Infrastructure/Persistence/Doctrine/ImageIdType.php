<?php

declare(strict_types=1);

namespace Cbase\ArtefactGuide\Infrastructure\Persistence\Doctrine;

use Cbase\Shared\Domain\ImageId;
use Cbase\Shared\Infrastructure\Persistence\Doctrine\UuidType;

final class ImageIdType extends UuidType
{
    public const TYPE = 'image_id';

    public static function customTypeName(): string
    {
        return self::TYPE;
    }

    protected function typeClassName(): string
    {
        return ImageId::class;
    }
}
