<?php

declare(strict_types=1);

namespace Cbase\ArtefactGuide\Application\Controller;

use Cbase\ArtefactGuide\Application\Action\UpdateArtefact\UpdateArtefactCommand;
use Cbase\ArtefactGuide\Application\Action\UpdateArtefact\UpdateArtefactHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[AsController]
final class UpdateArtefact extends AbstractController
{
    public function __construct(
        private SerializerInterface   $serializer,
        private UpdateArtefactHandler $updateArtefactCommandHandler,
    ) {
    }

    #[Route(path: '/api/artefacts/{slug}', name: 'api_artefact_update', methods: [Request::METHOD_PATCH])]
    public function __invoke(string $slug, Request $request): JsonResponse
    {
        $command = $this->serializer->deserialize(
            $request->getContent(),
            UpdateArtefactCommand::class,
            'json'
        );

        $artefact = ($this->updateArtefactCommandHandler)($command);

        return new JsonResponse($artefact, Response::HTTP_OK);
    }
}
