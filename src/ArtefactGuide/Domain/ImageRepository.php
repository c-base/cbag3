<?php

declare(strict_types=1);

namespace Cbase\ArtefactGuide\Domain;

interface ImageRepository
{
    public function save(Image $image): void;

    /**
     * @param array<string> $imageIds
     * @return array<Image>
     */
    public function findByImageIds(array $imageIds): array;

    /**
     * @return array<Image>
     */
    public function all(): array;
}
