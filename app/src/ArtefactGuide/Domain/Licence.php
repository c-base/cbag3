<?php

declare(strict_types=1);

namespace Cbase\ArtefactGuide\Domain;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Cbase\Shared\Domain\ValueObject\StringValueObject;

#[ORM\Embeddable]
final class Licence extends StringValueObject
{
    public const CC_BY_NC_SA = 'CC-BY-NC-SA';
    public const CC_BY_NC = 'CC-BY-NC';
    public const CC_BY_SA = 'CC-BY-SA';
    public const CC_BY = 'CC-BY';

    public const VALID_LICENCES = [
        self::CC_BY,
        self::CC_BY_SA,
        self::CC_BY_NC_SA,
        self::CC_BY_NC,
    ];

    #[ORM\Column(name: 'licence', type: Types::STRING, length: 25, nullable: false)]
    protected string $value;

    public function __construct(string $value)
    {
        if (!\in_array($value, static::VALID_LICENCES, true)) {
            throw new \InvalidArgumentException("Licence should be a valid value: {$value}.");
        }

        parent::__construct($value);
    }

    public static function create(string $value): self
    {
        return new self($value);
    }
}
