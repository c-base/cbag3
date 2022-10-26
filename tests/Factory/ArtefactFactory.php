<?php
/*
 * (c) 2022 dazz <dazz@c-base.org>
 *
 * For copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Tests\Factory;

use ArtefactGuide\Domain\Artefact;
use ArtefactGuide\Domain\MemberName;
use ArtefactGuide\Domain\Slug;
use Shared\Domain\ArtefactId;
use Shared\Domain\ValueObject\Uuid;

final class ArtefactFactory
{
    use FakerCapability;

    public static function create(): Artefact
    {
        return Artefact::create(
            ArtefactIdFactory::create(Uuid::random()->value()),
            self::faker()->words(2, true),
            self::faker()->words(2, true),
            Slug::create(self::faker()->slug()),
            self::faker()->text(),
            self::faker()->dateTimeThisMonth('now'),
            MemberName::create(self::faker()->userName())
        );
    }
}
