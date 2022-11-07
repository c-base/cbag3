<?php
/*
 * (c) 2022 dazz <dazz@c-base.org>
 *
 * For copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Cbase\Shared\Infrastructure\Persistence\Doctrine;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use Cbase\Shared\Domain\ValueObject\Uuid;
use Cbase\Shared\Infrastructure\Persistence\Doctrine\Dbal\DoctrineCustomType;

abstract class UuidType extends StringType implements DoctrineCustomType
{
    public function getName(): string
    {
        return static::customTypeName();
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return null;
        }
        $className = $this->typeClassName();

        return new $className($value);
    }

    /**
     * @param Uuid|null $value
     * @return mixed|string
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return ($value instanceof Uuid) ? $value->value() : $value;
    }

    abstract protected function typeClassName(): string;
}
