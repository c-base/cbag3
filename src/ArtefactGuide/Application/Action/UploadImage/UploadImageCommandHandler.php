<?php
/*
 * (c) 2022 dazz <dazz@c-base.org>
 *
 * For copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Cbase\ArtefactGuide\Application\Action\UploadImage;

use Cbase\ArtefactGuide\Domain\Image;
use Cbase\ArtefactGuide\Domain\ImageRepository;
use Cbase\ArtefactGuide\Domain\Licence;
use Cbase\Shared\Domain\ImageId;
use Cbase\Shared\Domain\Utils\StringUtils;

final class UploadImageCommandHandler
{
    public function __construct(private ImageRepository $imageRepository, private string $imagesUploadDirectory)
    {
    }

    public function __invoke(UploadImageCommand $command): array
    {
        $uploadedImage = $command->image;

        $originalFilename = pathinfo($uploadedImage->getClientOriginalName(), PATHINFO_FILENAME);
        // this is needed to safely include the file name as part of the URL
        $safeFilename = StringUtils::sluggify($originalFilename);
        $filename = $safeFilename . '_' . uniqid() . '.' . $uploadedImage->guessExtension();

        // Move the file to the directory where they are stored
        $uploadedImage->move($this->imagesUploadDirectory, $filename);

        $image = Image::create(
            ImageId::create(ImageId::random()->value()),
            $filename,
            $command->description,
            $command->author,
            new \DateTimeImmutable(),
            Licence::create(Licence::CC_BY_NC_SA)
        );

        $this->imageRepository->save($image);

        return $image->normalize();
    }
}
