<?php

declare(strict_types=1);

namespace Cbase\ArtefactGuide\Domain;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Cbase\Shared\Domain\Utils\StringUtils;
use Cbase\Shared\Domain\ValueObject\StringValueObject;

#[ORM\Embeddable]
final class Slug extends StringValueObject
{
    #[ORM\Column(name: 'slug', type: Types::STRING, length: 255, unique: true, nullable: false)]
    protected string $value;

    public static function create(string $value): self
    {
        return new self($value);
    }
}
