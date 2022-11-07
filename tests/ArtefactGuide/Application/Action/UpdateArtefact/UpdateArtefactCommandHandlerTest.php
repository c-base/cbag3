<?php
/*
 * (c) 2022 dazz <dazz@c-base.org>
 *
 * For copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Tests\ArtefactGuide\Application\Action\UpdateArtefact;

use Cbase\ArtefactGuide\Application\Action\UpdateArtefact\UpdateArtefactCommand;
use Cbase\ArtefactGuide\Application\Action\UpdateArtefact\UpdateArtefactCommandHandler;
use Cbase\ArtefactGuide\Domain\ArtefactRepository;
use Cbase\ArtefactGuide\Domain\ImageRepository;
use Cbase\Shared\Domain\ValueObject\Uuid;
use Doctrine\Common\Collections\ArrayCollection;
use Nyholm\NSA;
use Tests\Factory\ArtefactGuide\ArtefactFactory;
use Tests\Factory\ArtefactGuide\ImageFactory;
use Tests\Shared\Infrastructure\PhpUnit\InfrastructureTestCase;

final class UpdateArtefactCommandHandlerTest extends InfrastructureTestCase
{
    public function test_handler_can_update_the_primary_image(): void
    {
        $slug = 'mtc';
        $image = ImageFactory::create();
        $artefact = ArtefactFactory::create($slug);
        $artefact->addImage($image);
        $artefact->addImage(ImageFactory::create());

        self::assertEmpty(NSA::getProperty($artefact, 'primaryImage'));

        $artefactRepository = $this->service(ArtefactRepository::class);
        /** @var ArtefactRepository $artefactRepository */
        $artefactRepository->save($artefact);

        $command = new UpdateArtefactCommand();
        $command->id = $slug;
        $command->artefact = ['primaryImage' => $image->getImageId()->value()];

        $handler = $this->service(UpdateArtefactCommandHandler::class);

        $artefact = ($handler)($command);

        $primaryImage = NSA::getProperty($artefact, 'primaryImage');
        self::assertNotEmpty($primaryImage);
        self::assertEquals($primaryImage, $image);
    }

    public function test_handler_can_update_images(): void
    {
        $slug = 'mtc';
        $image = ImageFactory::create();
        $artefact = ArtefactFactory::create($slug);
        $artefact->addImage($image);
        $artefact->addImage(ImageFactory::create());

        self::assertCount(2, NSA::getProperty($artefact, 'images'));

        $artefactRepository = $this->service(ArtefactRepository::class);
        /** @var ArtefactRepository $artefactRepository */
        $artefactRepository->save($artefact);

        $imageRepository = $this->service(ImageRepository::class);
        /** @var ImageRepository $imageRepository */
        $imageRepository->save($image);

        $command = new UpdateArtefactCommand();
        $command->id = $slug;
        $command->artefact = ['images' => [
            ['id' => $image->getImageId()->value()]
        ]];

        $handler = $this->service(UpdateArtefactCommandHandler::class);

        $artefact = ($handler)($command);

        /** @var ArrayCollection $artefactImages */
        $artefactImages = NSA::getProperty($artefact, 'images');
        self::assertCount(1, $artefactImages);
        self::assertEquals($image->getImageId(), $artefactImages->first()->getImageId());
    }

    public function test_handler_can_delete_images(): void
    {
        $slug = 'mtc';
        $image = ImageFactory::create();
        $artefact = ArtefactFactory::create($slug);
        $artefact->addImage($image);
        $artefact->addImage(ImageFactory::create());

        self::assertCount(2, NSA::getProperty($artefact, 'images'));

        $artefactRepository = $this->service(ArtefactRepository::class);
        /** @var ArtefactRepository $artefactRepository */
        $artefactRepository->save($artefact);

        $imageRepository = $this->service(ImageRepository::class);
        /** @var ImageRepository $imageRepository */
        $imageRepository->save($image);

        $command = new UpdateArtefactCommand();
        $command->id = $slug;
        $command->artefact = ['images' => []];

        $handler = $this->service(UpdateArtefactCommandHandler::class);

        $artefact = ($handler)($command);

        /** @var ArrayCollection $artefactImages */
        $artefactImages = NSA::getProperty($artefact, 'images');
        self::assertTrue($artefactImages->isEmpty());
    }
}
