<?php

declare(strict_types=1);

namespace Tests\Factory\ArtefactGuide;

use Cbase\ArtefactGuide\Domain\Artefact;
use Cbase\ArtefactGuide\Domain\Slug;
use Cbase\Shared\Domain\ArtefactId;
use Cbase\Shared\Domain\MemberName;
use Tests\Factory\FakerCapability;

final class ArtefactFactory
{
    use FakerCapability;

    public static function create(?string $slug = null): Artefact
    {
        return Artefact::create(
            ArtefactId::create(),
            self::faker()->words(2, true),
            self::faker()->words(2, true),
            Slug::create($slug ?: self::faker()->slug()),
            self::faker()->text(),
            self::faker()->dateTimeThisMonth('now'),
            MemberName::create(self::faker()->userName())
        );
    }
}
