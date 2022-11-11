<?php
/*
 * (c) 2022 dazz <dazz@c-base.org>
 *
 * For copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Cbase\ArtefactGuide\Application\Action\UploadImage;

use Symfony\Component\HttpFoundation\File\UploadedFile;

final class UploadImageCommand
{
    public function __construct(
        public readonly UploadedFile $image,
        public readonly string $description,
        public readonly string $author,
    ) {
    }

    public static function create(UploadedFile $image, string $description, string $author): self
    {
        return new self($image, $description, $author);
    }
}
