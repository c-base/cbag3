<?php

declare(strict_types=1);

namespace Tests\ArtefactGuide\Application\Action\UpdateArtefact;

use Cbase\ArtefactGuide\Application\Action\UpdateArtefact\UpdateArtefactCommand;
use Cbase\ArtefactGuide\Application\Action\UpdateArtefact\UpdateArtefactHandler;
use Cbase\ArtefactGuide\Domain\Image;
use Cbase\Shared\Domain\ValueObject\Uuid;
use Doctrine\Common\Collections\ArrayCollection;
use Nyholm\NSA;
use Tests\ArtefactGuide\Infrastructure\PhpUnit\ArtefactGuideInfrastructureTestCase;
use Tests\Factory\ArtefactGuide\ArtefactFactory;
use Tests\Factory\ArtefactGuide\ImageFactory;

final class UpdateArtefactHandlerTest extends ArtefactGuideInfrastructureTestCase
{
    public function test_handler_can_update_the_primary_image(): void
    {
        $slug = 'mtc';
        $image = ImageFactory::create();
        $artefact = ArtefactFactory::create($slug);
        $artefact->addImage($image);
        $artefact->addImage(ImageFactory::create());

        self::assertEmpty(NSA::getProperty($artefact, 'primaryImage'));

        $this->artefactRepository()->save($artefact);

        $command = new UpdateArtefactCommand();
        $command->id = $slug;
        $command->artefact = ['primaryImage' => $image->getImageId()->value()];

        $handler = $this->service(UpdateArtefactHandler::class);
        self::assertInstanceOf(UpdateArtefactHandler::class, $handler);

        $artefact = ($handler)($command);

        $primaryImage = NSA::getProperty($artefact, 'primaryImage');
        self::assertNotEmpty($primaryImage);
        self::assertEquals($primaryImage, $image);
    }

    public function test_handler_can_only_update_the_primary_image_when_in_images(): void
    {
        $slug = 'mtc';
        $image = ImageFactory::create();
        $artefact = ArtefactFactory::create($slug);
        $artefact->addImage($image);
        $artefact->addImage(ImageFactory::create());

        self::assertEmpty(NSA::getProperty($artefact, 'primaryImage'));

        $this->artefactRepository()->save($artefact);

        $command = new UpdateArtefactCommand();
        $command->id = $slug;
        $command->artefact = ['primaryImage' => Uuid::random()->value()];

        $handler = $this->service(UpdateArtefactHandler::class);
        self::assertInstanceOf(UpdateArtefactHandler::class, $handler);

        $artefact = ($handler)($command);

        $primaryImage = NSA::getProperty($artefact, 'primaryImage');
        self::assertNull($primaryImage);
    }

    public function test_handler_can_update_images(): void
    {
        $slug = 'mtc';
        $image = ImageFactory::create();
        $artefact = ArtefactFactory::create($slug);
        $artefact->addImage($image);
        $artefact->addImage(ImageFactory::create());

        /** @var ArrayCollection $images */
        $images = NSA::getProperty($artefact, 'images');

        self::assertCount(2, $images);

        $this->artefactRepository()->save($artefact);
        $this->imageRepository()->save($image);

        $command = new UpdateArtefactCommand();
        $command->id = $slug;
        $command->artefact = ['images' => [
            ['id' => $image->getImageId()->value()]
        ]];

        $handler = $this->service(UpdateArtefactHandler::class);

        $artefact = ($handler)($command);

        /** @var ArrayCollection<int, Image> $artefactImages */
        $artefactImages = NSA::getProperty($artefact, 'images');

        self::assertCount(1, $artefactImages);
        self::assertInstanceOf(Image::class, $artefactImages[0]);
        self::assertEquals($image->getImageId(), $artefactImages[0]->getImageId());
    }

    public function test_handler_can_delete_images(): void
    {
        $slug = 'mtc';
        $image = ImageFactory::create();
        $artefact = ArtefactFactory::create($slug);
        $artefact->addImage($image);
        $artefact->addImage(ImageFactory::create());

        self::assertCount(2, NSA::getProperty($artefact, 'images'));

        $this->artefactRepository()->save($artefact);
        $this->imageRepository()->save($image);

        $command = new UpdateArtefactCommand();
        $command->id = $slug;
        $command->artefact = ['images' => []];

        $handler = $this->service(UpdateArtefactHandler::class);

        $artefact = ($handler)($command);

        /** @var ArrayCollection<int, Image> $artefactImages */
        $artefactImages = NSA::getProperty($artefact, 'images');
        self::assertEmpty($artefactImages);
    }
}
