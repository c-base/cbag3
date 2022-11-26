<?php

declare(strict_types=1);

namespace Tests\ArtefactGuide\Application\Action\UploadImage;

use Cbase\ArtefactGuide\Application\Action\UploadImage\UploadImageCommand;
use Cbase\ArtefactGuide\Application\Action\UploadImage\UploadImageHandler;
use Cbase\ArtefactGuide\Domain\ImageRepository;
use Cbase\ArtefactGuide\Domain\Licence;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Tests\ArtefactGuide\Infrastructure\PhpUnit\ArtefactGuideInfrastructureTestCase;

final class UploadImageHandlerTest extends ArtefactGuideInfrastructureTestCase
{
    public function test_handler_can_save_an_uploaded_image(): void
    {
        $fileName = 'spacestation.jpg';
        $path = __DIR__ . DIRECTORY_SEPARATOR . $fileName;
        $image = new UploadedFile($path, $fileName, 'image/jpeg', 0, true);
        $command = UploadImageCommand::create($image, 'description', 'alien', Licence::CC_BY_NC);

        self::assertEquals($image, $command->image);

        $imagesUploadDirectory = __DIR__ . '/uploads';
        $handler = new UploadImageHandler($this->imageRepository(), $imagesUploadDirectory);

        $image = ($handler)($command);

        $serializedImage = $image->jsonSerialize();

        // revert file move
        rename($imagesUploadDirectory . DIRECTORY_SEPARATOR . $serializedImage['path'], $path);

        self::assertEquals('description', $serializedImage['description']);
        self::assertEquals('alien', $serializedImage['author']);

        self::assertCount(1, $this->imageRepository()->findByImageIds([$serializedImage['id']]));
    }
}
