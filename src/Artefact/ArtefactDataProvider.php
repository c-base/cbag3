<?php

namespace App\Artefact;

use App\Repository\ArtefactRepository;

class ArtefactDataProvider {

    private ArtefactRepository $artefactRepository;

    public function __construct(ArtefactRepository $artefactRepository)
    {
        $this->artefactRepository = $artefactRepository;
    }

    public function getCollection(): array
    {
        return $this->artefactRepository->findAll();
    }
}