<?php

namespace ArtefactGuide\Infrastructure\Persistence\Doctrine\Repository;

use ArtefactGuide\Domain\Artefact;
use ArtefactGuide\Domain\ArtefactCollection;
use ArtefactGuide\Domain\ArtefactRepository;
use Doctrine\Persistence\ManagerRegistry;
use Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;

final class DoctrineArtefactRepository extends DoctrineRepository implements ArtefactRepository
{
    public function save(Artefact $artefact): void
    {
        $this->persist($artefact);
    }

    public function all(): ArtefactCollection
    {
        return $this->repository(Artefact::class)->findAll();
    }
}
