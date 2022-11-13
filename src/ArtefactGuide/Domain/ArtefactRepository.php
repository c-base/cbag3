<?php
declare(strict_types=1);

namespace Cbase\ArtefactGuide\Domain;

interface ArtefactRepository
{
    public function all(): array;

    public function save(Artefact $artefact): void;

    public function getBySlug(string $slug): Artefact;
}
