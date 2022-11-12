<?php
declare(strict_types=1);

namespace Cbase\ArtefactGuide\Domain;

use Cbase\Shared\Domain\Collection;

final class ImageCollection extends Collection
{
    protected function getType(): string
    {
        return Image::class;
    }
}
