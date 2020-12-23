<?php
/*
 * (c) 2019 dazz <dazz@c-base.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare (strict_types=1);

namespace App\Service\RequestObject;

use App\Entity\Asset;

class UploadAsset implements RequestObjectInterface
{
    /** @var string */
    public $description;
    /** @var string */
    public $author;
    /** @var string */
    public $license;
    /** @var string */
    public $encodedImage;

    private $path;

    public function createAsset(string $basePath): Asset
    {
        if (!$this->path) {
            $this->path = 'uuid';

            $basePath . DIRECTORY_SEPARATOR . $this->path;
        }
        return new Asset($this->path, $this->description, $this->author, $this->license);
    }
}
