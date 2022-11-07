<?php
/*
 * (c) 2022 dazz <dazz@c-base.org>
 *
 * For copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Cbase\ArtefactGuide\Domain;

use Doctrine\Common\Collections\ArrayCollection;

interface ImageRepository
{
    public function save(Image $image): void;

    /**
     * @param array<string> $imageIds
     * @return ArrayCollection<int, object>
     */
    public function findByImageIds(array $imageIds): ArrayCollection;
}
