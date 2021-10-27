<?php

namespace App\Artefact;

use App\Entity\Artefact;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 */
class ArtefactController extends AbstractController
{
    private ArtefactDataProvider $provider;

    public function __construct(ArtefactDataProvider $provider)
    {
        $this->provider = $provider;
    }

    /**
     * @Route("/artefacts", name="api_artefact_collection", methods={"get"})
     */
    public function collection(): JsonResponse
    {
        return $this->json([
            'artefacts' => $this->provider->getCollection(),
        ]);
    }

    /**
     * @Route("/artefacts/{slug}", name="api_artefact_item", methods={"get"})
     */
    public function item(Artefact $artefact): JsonResponse
    {
        return $this->json([
            'artefact' => $artefact,
        ]);
    }
}
