<?php
declare(strict_types=1);

namespace Cbase\ArtefactGuide\Application\Controller;

use Cbase\ArtefactGuide\Application\Action\ListImages\ListImagesHandler;
use Cbase\ArtefactGuide\Application\Action\ListImages\ListImagesQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
final class ListImages extends AbstractController
{
    public function __construct(private ListImagesHandler $listImagesHandler)
    {
    }

    #[Route(path: '/api/images', name: 'api_image_collection', methods: [Request::METHOD_GET])]
    public function __invoke(): JsonResponse
    {
        return $this->json([
            'images' => ($this->listImagesHandler)(ListImagesQuery::create())
        ]);
    }

}
