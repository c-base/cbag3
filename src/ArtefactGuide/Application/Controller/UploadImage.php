<?php
/*
 * (c) 2022 dazz <dazz@c-base.org>
 *
 * For copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Cbase\ArtefactGuide\Application\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
final class UploadImage extends AbstractController
{
    #[Route(path: '/api/images', name: 'api_gallery_upload', methods: [Request::METHOD_POST])]
    public function __invoke(Request $request): JsonResponse
    {
        return new JsonResponse([
            'images' => [],
        ]);
    }
}
