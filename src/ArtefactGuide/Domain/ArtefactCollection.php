<?php
/*
 * (c) 2022 dazz <dazz@c-base.org>
 *
 * For copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Cbase\ArtefactGuide\Domain;

use Cbase\Shared\Domain\Collection;

class ArtefactCollection extends Collection
{
    protected function getType(): string
    {
        return Artefact::class;
    }
}
