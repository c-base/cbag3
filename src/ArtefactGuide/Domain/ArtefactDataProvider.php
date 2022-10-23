<?php
/*
 * (c) 2021 dazz <dazz@c-base.org>
 *
 * For copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace ArtefactGuide\Domain;

use ArtefactGuide\Infrastructure\Repository\ArtefactRepository;

class ArtefactDataProvider
{
    public function __construct(private readonly ArtefactRepository $artefactRepository)
    {
    }

    public function getCollection(): array
    {
        return $this->artefactRepository->findAll();
    }
}
