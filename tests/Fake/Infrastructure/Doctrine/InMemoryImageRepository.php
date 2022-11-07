<?php
/*
 * (c) 2022 dazz <dazz@c-base.org>
 *
 * For copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Tests\Fake\Infrastructure\Doctrine;

use Cbase\ArtefactGuide\Domain\Image;
use Cbase\ArtefactGuide\Domain\ImageRepository;
use Doctrine\Common\Collections\ArrayCollection;

final class InMemoryImageRepository implements ImageRepository
{
    private array $images;

    public function __construct()
    {
        $this->artefacts = new ArrayCollection();
    }

    public function save(Image $image): void
    {
        $this->artefacts->add($image);
    }

    public function findByImageIds(array $imageIds): ArrayCollection
    {
        return $this->artefacts->filter(
            fn(Image $image) => in_array($image->getImageId()->value(), $imageIds, true)
        );
    }
}
