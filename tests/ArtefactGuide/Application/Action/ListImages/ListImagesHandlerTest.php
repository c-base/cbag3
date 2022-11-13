<?php

declare(strict_types=1);

namespace Tests\ArtefactGuide\Application\Action\ListImages;

use Cbase\ArtefactGuide\Application\Action\ListImages\ListImagesHandler;
use Cbase\ArtefactGuide\Application\Action\ListImages\ListImagesQuery;
use Cbase\ArtefactGuide\Domain\ImageCollection;
use Tests\ArtefactGuide\Infrastructure\PhpUnit\ArtefactGuideInfrastructureTestCase;
use Tests\Factory\ArtefactGuide\ImageFactory;

final class ListImagesHandlerTest extends ArtefactGuideInfrastructureTestCase
{
    public function test_the_handler_can_fetch_an_empty_image_collection(): void
    {
        /** @var ListImagesHandler $handler */
        $handler = $this->service(ListImagesHandler::class);

        $images = ($handler)(ListImagesQuery::create());

        self::assertInstanceOf(ImageCollection::class, $images);
        self::assertCount(0, $images);
    }

    public function test_the_handler_can_fetch_an_image_collection(): void
    {
        $this->imageRepository()->save(ImageFactory::create());

        /** @var ListImagesHandler $handler */
        $handler = $this->service(ListImagesHandler::class);

        $images = ($handler)(ListImagesQuery::create());

        self::assertInstanceOf(ImageCollection::class, $images);
        self::assertCount(1, $images);
    }
}
