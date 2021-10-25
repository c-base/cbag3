<?php

namespace App\App;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    /**
     * @Route("/", name="app_index")
     */
    public function index(): Response
    {
        $config = [
            'resources' => [
                'artefacts' => [
                    'path' => $this->generateUrl('artefact_collection'),
                    'methods' => 'get'
                    ],
            ]
        ];
        return $this->render('app/index.html.twig', [
            'config' => json_encode($config),
        ]);
    }
}
