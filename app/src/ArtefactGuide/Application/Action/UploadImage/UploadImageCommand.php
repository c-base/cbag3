<?php

declare(strict_types=1);

namespace Cbase\ArtefactGuide\Application\Action\UploadImage;

use Symfony\Component\HttpFoundation\File\UploadedFile;

final class UploadImageCommand
{
    public function __construct(
        public readonly UploadedFile $image,
        public readonly string $description,
        public readonly string $author,
        public readonly string $licence,
    ) {
    }

    public static function create(UploadedFile $image, string $description, string $author, string $licence): self
    {
        return new self($image, $description, $author, $licence);
    }
}
