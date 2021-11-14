<?php
/*
 * (c) 2021 dazz <dazz@c-base.org>
 *
 * For copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare (strict_types=1);

namespace App\Artefact;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 */
class getCollectionController extends AbstractController
{
    /** @var ArtefactDataProvider */
    private $provider;

    public function __construct(ArtefactDataProvider $provider)
    {
        $this->provider = $provider;
    }

    /**
     * @Route("/artefacts", name="api_artefact_collection", methods={"get"})
     */
    public function __invoke(): JsonResponse
    {
        return $this->json([
            'artefacts' => $this->provider->getCollection(),
        ]);
    }
}
