<?php

declare(strict_types=1);

namespace Cbase\ArtefactGuide\Application\Controller;

use Assert\Assert;
use Cbase\ArtefactGuide\Application\Action\UploadImage\UploadImageCommand;
use Cbase\ArtefactGuide\Application\Action\UploadImage\UploadImageHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
final class UploadImage extends AbstractController
{
    public function __construct(
        private UploadImageHandler $uploadImageHandler,
    ) {
    }

    #[Route(path: '/api/images', name: 'api_gallery_upload', methods: [Request::METHOD_POST])]
    public function __invoke(Request $request): JsonResponse
    {
        /** @var UploadedFile $uploadedFile */
        $uploadedFile = $request->files->get('image');
        Assert::that($uploadedFile)->isInstanceOf(UploadedFile::class);

        $command = UploadImageCommand::create(
            $uploadedFile,
            'test',
            'alien'
        );

        $image = ($this->uploadImageHandler)($command);

        return new JsonResponse([
            'image' => $image,
        ]);
    }
}
