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
use Shared\Domain\ArtefactId;

final class ArtefactFactory
{
    public static function create(): Artefact
    {
        return new Artefact::create(
            ArtefactId::random(),
            $name,
            $cName,
            $slug,
            $description,
            $createdAt,
            $createdBy
        );
    }
}
