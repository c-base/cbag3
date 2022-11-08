<?php
/*
 * (c) 2022 dazz <dazz@c-base.org>
 *
 * For copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Cbase\ArtefactGuide\Application\Action\UploadImage;

use Symfony\Component\HttpFoundation\File\File;

final class UploadImageCommand
{
    public function __construct(
        public readonly File $image,
        public readonly string $description,
        public readonly string $author,
    ) {
    }

    public static function create(File $image, string $description, string $author): self
    {
        return new self($image, $description, $author);
    }
}
