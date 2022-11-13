<?php

declare(strict_types=1);

namespace Cbase\ArtefactGuide\Application\Controller;

use Cbase\ArtefactGuide\Application\Action\ListArtefacts\ListArtefactsHandler;
use Cbase\ArtefactGuide\Application\Action\ListArtefacts\ListArtefactsQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
class ListArtefacts extends AbstractController
{
    public function __construct(private ListArtefactsHandler $listArtefactsHandler)
    {
    }

    #[Route(path: "/api/artefacts", name: 'api_artefact_collection', methods: [Request::METHOD_GET])]
    public function __invoke(): JsonResponse
    {
        return $this->json([
            'artefacts' => ($this->listArtefactsHandler)(ListArtefactsQuery::create()),
        ]);
    }
}
