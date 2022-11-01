<?php
/*
 * (c) 2021 dazz <dazz@c-base.org>
 *
 * For copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Cbase\ArtefactGuide\Application\Controller;

use Cbase\ArtefactGuide\Domain\Artefact;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
class GetArtefact extends AbstractController
{
    #[Route(path: '/api/artefacts/{slug}', name: 'api_artefact_item', methods: [Request::METHOD_GET])]
    public function __invoke(Artefact $artefact): JsonResponse
    {
        return $this->json([
            'artefact' => $artefact,
        ]);
    }
}
