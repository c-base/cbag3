<?php

namespace Cbase\ArtefactGuide\Infrastructure\Persistence\Doctrine\Repository;

use Cbase\ArtefactGuide\Domain\Artefact;
use Cbase\ArtefactGuide\Domain\ArtefactRepository;
use Cbase\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;

final class DoctrineArtefactRepository extends DoctrineRepository implements ArtefactRepository
{
    public function save(Artefact $artefact): void
    {
        $this->persist($artefact);
    }

    public function all(): array
    {
        return $this->repository(Artefact::class)->findAll();
    }

    public function getBySlug(string $slug): Artefact
    {
        return $this->repository(Artefact::class)->findOneBy(['slug.value' => $slug]);
    }
}
