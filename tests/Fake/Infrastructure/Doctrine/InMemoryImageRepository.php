<?php
/*
 * (c) 2022 dazz <dazz@c-base.org>
 *
 * For copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Tests\Fake\Infrastructure\Doctrine;

use Cbase\ArtefactGuide\Domain\Image;
use Cbase\ArtefactGuide\Domain\ImageCollection;
use Cbase\ArtefactGuide\Domain\ImageRepository;

final class InMemoryImageRepository implements ImageRepository
{
    private ImageCollection $images;

    public function __construct()
    {
        $this->images = ImageCollection::create();
    }

    public function save(Image $image): void
    {
        $this->images->append($image);
    }

    public function findByImageIds(array $imageIds): ImageCollection
    {
        return ImageCollection::create(
            array_filter(
                $this->images->getArrayCopy(),
                fn (Image $image) => in_array($image->getImageId()->value(), $imageIds, true)
            )
        );
    }

    public function all(): ImageCollection
    {
        return $this->images;
    }

}
