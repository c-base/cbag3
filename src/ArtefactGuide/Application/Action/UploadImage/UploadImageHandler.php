<?php

declare(strict_types=1);

namespace Cbase\ArtefactGuide\Application\Action\UploadImage;

use Cbase\ArtefactGuide\Domain\Image;
use Cbase\ArtefactGuide\Domain\ImageRepository;
use Cbase\ArtefactGuide\Domain\Licence;
use Cbase\Shared\Domain\ImageId;
use Cbase\Shared\Domain\Utils\StringUtils;

final class UploadImageHandler
{
    public function __construct(private ImageRepository $imageRepository, private string $imagesUploadDirectory)
    {
    }

    public function __invoke(UploadImageCommand $command): Image
    {
        $uploadedImage = $command->image;

        $originalFilename = pathinfo($uploadedImage->getClientOriginalName(), PATHINFO_FILENAME);
        // this is needed to safely include the file name as part of the URL
        $safeFilename = StringUtils::sluggify($originalFilename);
        $filename = $safeFilename . '_' . uniqid() . '.' . $uploadedImage->guessExtension();

        // Move the file to the directory where they are stored
        $uploadedImage->move($this->imagesUploadDirectory, $filename);

        $image = Image::create(
            ImageId::create(),
            $filename,
            $command->description,
            $command->author,
            new \DateTimeImmutable(),
            Licence::create(Licence::CC_BY_NC_SA)
        );

        $this->imageRepository->save($image);

        return $image;
    }
}
