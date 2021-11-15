<?php

namespace App\Artefact;

use App\Repository\ArtefactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArtefactDataProvider extends AbstractController
{
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
