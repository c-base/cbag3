<?php

declare(strict_types=1);

namespace Cbase\App\Application\Controller;

use Cbase\Shared\Domain\FrontendConfig;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
class IndexController extends AbstractController
{
    public function __construct(private FrontendConfig $config)
    {
    }

    public const APP_INDEX = 'app_index';

    #[Route(
        path: "/{reactRouting}",
        name: self::APP_INDEX,
        priority: -1,
        defaults: ["reactRouting" => null],
        methods: [Request::METHOD_GET],
        requirements: ["reactRouting" => ".+"],
    )]
    public function __invoke(): Response
    {
        return $this->render('app/index.html.twig', [
            'config' => json_encode($this->config),
        ]);
    }
}
