<?php
declare(strict_types=1);

namespace Cbase\ArtefactGuide\Infrastructure\Persistence\Doctrine\Repository;

use Cbase\ArtefactGuide\Domain\Image;
use Cbase\ArtefactGuide\Domain\ImageRepository;
use Cbase\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;

final class DoctrineImageRepository extends DoctrineRepository implements ImageRepository
{
    public function save(Image $image): void
    {
        $this->persist($image);
    }

    public function findByImageIds(array $imageIds): array
    {
        return $this->repository(Image::class)->findBy(['imageId' => $imageIds]);
    }

    public function all(): array
    {
        return $this->repository(Image::class)->findAll();
    }
}
