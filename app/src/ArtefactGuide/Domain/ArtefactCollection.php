<?php

declare(strict_types=1);

namespace Cbase\ArtefactGuide\Domain;

use Cbase\Shared\Domain\Collection;

/** @extends Collection<Artefact> */
final class ArtefactCollection extends Collection
{
    protected function getType(): string
    {
        return Artefact::class;
    }
}
