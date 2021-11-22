<?php
/*
 * (c) 2021 dazz <dazz@c-base.org>
 *
 * For copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace App\Artefact;

use App\Repository\ArtefactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArtefactDataProvider extends AbstractController
{
    public function __construct(private ArtefactRepository $artefactRepository)
    {
    }

    public function getCollection(): array
    {
        return $this->artefactRepository->findAll();
    }
}
