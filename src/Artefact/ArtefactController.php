<?php

namespace App\Artefact;

use App\Entity\Artefact;
use App\Repository\ArtefactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class ArtefactController extends AbstractController
{
    private ArtefactRepository $artefactRepository;
    public function __construct(ArtefactRepository $artefactRepository)
    {
        $this->artefactRepository = $artefactRepository;
    }

    /**
     * @Route("/artefacts", name="artefact_collection", methods={"get"})
     */
    public function collection(Environment $twig): Response
    {
        return new Response($twig->render('artefact/collection.html.twig', [
            'artefacts' => $this->artefactRepository->findAll(),
        ]));
    }

    /**
     * @Route("/artefacts/{slug}", name="artefact_item", methods={"get"})
     */
    public function item(Environment $twig, Artefact $artefact): Response
    {
        return new Response($twig->render('artefact/item.html.twig', [
            'artefact' => $artefact,
        ]));
    }
}
