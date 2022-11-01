<?php
/*
 * (c) 2022 dazz <dazz@c-base.org>
 *
 * For copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Tests\Factory\ArtefactGuide;

use Cbase\ArtefactGuide\Domain\Image;
use Cbase\ArtefactGuide\Domain\Licence;
use Cbase\Shared\Domain\ImageId;
use Cbase\Shared\Domain\ValueObject\Uuid;
use Tests\Factory\FakerCapability;

final class ImageFactory
{
    use FakerCapability;

    public static function create(): Image
    {
        return Image::create(
            ImageId::create(),
            sprintf('%s.jpg', Uuid::random()),
            self::faker()->text(),
            self::faker()->userName(),
            self::faker()->dateTimeThisMonth('now'),
            Licence::create(Licence::CC_BY_SA)
        );
    }
}
