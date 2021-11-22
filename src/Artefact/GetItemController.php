<?php
/*
 * (c) 2021 dazz <dazz@c-base.org>
 *
 * For copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace App\Artefact;

use App\Entity\Artefact;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 */
class GetItemController extends AbstractController
{
    /**
     * @Route("/artefacts/{slug}", name="api_artefact_item", methods={"get"})
     */
    public function __invoke(Artefact $artefact): JsonResponse
    {
        return $this->json([
            'artefact' => $artefact,
        ]);
    }
}
