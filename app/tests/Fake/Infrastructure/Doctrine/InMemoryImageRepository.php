<?php

declare(strict_types=1);

namespace Tests\Fake\Infrastructure\Doctrine;

use Cbase\ArtefactGuide\Domain\Image;
use Cbase\ArtefactGuide\Domain\ImageRepository;
use Doctrine\Common\Collections\ArrayCollection;

final class InMemoryImageRepository implements ImageRepository
{
    /**
     * @var ArrayCollection<int, Image>
     */
    private ArrayCollection $images;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    /**
     * {@inheritDoc}
     */
    public function all(): array
    {
        return $this->images->toArray();
    }

    /**
     * {@inheritDoc}
     */
    public function findByImageIds(array $imageIds): array
    {
        return $this->images->filter(
            fn (Image $image) => \in_array($image->getImageId()->value(), $imageIds, true)
        )->toArray();
    }

    public function save(Image $image): void
    {
        $this->images->add($image);
    }
}
