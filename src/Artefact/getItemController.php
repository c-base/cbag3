<?php

namespace App\Artefact;

use App\Entity\Artefact;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 */
class getItemController extends AbstractController
{
    /**
     * @Route("/artefacts/{slug}", name="api_artefact_item", methods={"get"})
     */
    public function __invoke(Artefact $artefact): JsonResponse
    {
        return $this->json([
            'artefact' => $artefact,
        ]);
    }
}
