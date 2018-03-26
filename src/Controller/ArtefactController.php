<?php
namespace App\Controller;

use App\Utils\Slugger;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/artefacts")
 */
class ArtefactController extends AbstractController
{
    /**
     * @Route("/", name="artefact.collection", methods={"GET"})
     */
    public function collection()
    {
        return new Response('collection');
    }

    /**
     * @Route("/{slug}", name="artefact.item", methods={"GET"})
     */
    public function item()
    {
        return new Response('item');
    }

    /**
     * @Route("/", name="artefact.create", methods={"POST"})
     */
    public function create(Request $request, Slugger $slugger)
    {
        return new Response();
    }
}
