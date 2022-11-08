<?php
/*
 * (c) 2022 dazz <dazz@c-base.org>
 *
 * For copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Tests\ArtefactGuide\Application\Action\UploadImage;

use Cbase\ArtefactGuide\Application\Action\UploadImage\UploadImageCommand;
use Cbase\ArtefactGuide\Application\Action\UploadImage\UploadImageCommandHandler;
use Cbase\ArtefactGuide\Domain\ImageRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Tests\Shared\Infrastructure\PhpUnit\InfrastructureTestCase;

final class UploadImageCommandHandlerTest extends InfrastructureTestCase
{
    public function test_handler_can_save_an_uploaded_image(): void
    {
        $fileName = 'spacestation.jpg';
        $path = __DIR__ . DIRECTORY_SEPARATOR . $fileName;
        $image = new UploadedFile($path, $fileName, 'image/jpeg', 0, true);
        $command = UploadImageCommand::create($image, 'description', 'alien');

        self::assertEquals($image, $command->image);

        $imageRepository = $this->service(ImageRepository::class);
        /** @var ImageRepository $imageRepository */
        $imagesUploadDirectory = __DIR__ . '/uploads';
        $handler = new UploadImageCommandHandler($imageRepository, $imagesUploadDirectory);

        $image = ($handler)($command);

        // revert file move
        rename($imagesUploadDirectory . DIRECTORY_SEPARATOR . $image['path'], $path);

        self::assertEquals('description', $image['description']);
        self::assertEquals('alien', $image['author']);

        self::assertCount(1, $imageRepository->findByImageIds([$image['id']]));
    }
}
