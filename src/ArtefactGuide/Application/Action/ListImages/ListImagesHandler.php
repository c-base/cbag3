<?php
declare(strict_types=1);

namespace Cbase\ArtefactGuide\Application\Action\ListImages;

use Cbase\ArtefactGuide\Domain\ImageCollection;
use Cbase\ArtefactGuide\Domain\ImageRepository;

final class ListImagesHandler
{
    public function __construct(private ImageRepository $imageRepository)
    {
    }

    public function __invoke(ListImagesQuery $query): ImageCollection
    {
        return $this->imageRepository->all();
    }
}
