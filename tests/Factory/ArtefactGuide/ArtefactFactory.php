<?php
/*
 * (c) 2022 dazz <dazz@c-base.org>
 *
 * For copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
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

    public static function create(): Artefact
    {
        return Artefact::create(
            ArtefactId::create(),
            self::faker()->words(2, true),
            self::faker()->words(2, true),
            Slug::create(self::faker()->slug()),
            self::faker()->text(),
            self::faker()->dateTimeThisMonth('now'),
            MemberName::create(self::faker()->userName())
        );
    }
}
