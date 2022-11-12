<?php
declare(strict_types=1);

namespace Cbase\ArtefactGuide\Domain;

use Doctrine\Common\Collections\ArrayCollection;

interface ImageRepository
{
    public function save(Image $image): void;

    /**
     * @param array<string> $imageIds
     * @return ImageCollection<int, T>
     */
    public function findByImageIds(array $imageIds): ImageCollection;

    public function all(): ImageCollection;
}
