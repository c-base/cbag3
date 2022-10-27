<?php
/*
 * (c) 2022 dazz <dazz@c-base.org>
 *
 * For copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace ArtefactGuide\Infrastructure\Persistence\Doctrine;

use Shared\Domain\ArtefactId;
use Shared\Infrastructure\Persistence\Doctrine\UuidType;

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
