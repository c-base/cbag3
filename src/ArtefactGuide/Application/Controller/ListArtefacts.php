<?php
/*
 * (c) 2021 dazz <dazz@c-base.org>
 *
 * For copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
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
    public function __construct(private ListArtefactsHandler $getArtefactListHandler)
    {
    }

    #[Route(path: "/api/artefacts", name: 'api_artefact_collection', methods: [Request::METHOD_GET])]
    public function __invoke(): JsonResponse
    {
        return $this->json([
            'artefacts' => ($this->getArtefactListHandler)(new ListArtefactsQuery()),
        ]);
    }
}
