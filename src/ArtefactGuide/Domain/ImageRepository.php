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
    /**
     * @param array $imageIds
     * @return array<Image>
     */
    public function findByImageIds(array $imageIds): ArrayCollection;
}
