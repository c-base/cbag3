<?php
/*
 * (c) 2022 dazz <dazz@c-base.org>
 *
 * For copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Cbase\ArtefactGuide\Infrastructure\Persistence\Doctrine\Repository;

use Cbase\ArtefactGuide\Domain\Image;
use Cbase\ArtefactGuide\Domain\ImageRepository;
use Cbase\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;
use Doctrine\Common\Collections\ArrayCollection;

final class DoctrineImageRepository extends DoctrineRepository implements ImageRepository
{
    public function save(Image $artefact): void
    {
        $this->persist($artefact);
    }

    public function findByImageIds(array $imageIds): ArrayCollection
    {
        return new ArrayCollection(
            $this->repository(Image::class)->findBy(['imageId' => $imageIds])
        );
    }
}
