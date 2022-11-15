<?php

declare(strict_types=1);

namespace Cbase\App\Application\Controller;

use Cbase\ArtefactGuide\Domain\Licence;
use Cbase\Authentication\Application\Controller\Authenticate;
use Cbase\Authentication\Domain\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

#[AsController]
class IndexController extends AbstractController
{
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
        $config = [
            'auth' => $this->getAuth(),
            'resources' => $this->getApiResources(),
            'content' => ['licences' => Licence::VALID_LICENCES],
        ];
        return $this->render('app/index.html.twig', [
            'config' => json_encode($config),
        ]);
    }

    private function getAuth(): array
    {
        if (!$this->getUser()) {
            return [
                'authenticated' => false,
            ];
        }
        return [
            'authenticated' => true,
            'username' => $this->getUser()->getUserIdentifier(),
        ];
    }

    /**
     * @return array<string, \Symfony\Component\Routing\Route>
     */
    private function getApiResources(): array
    {
        /** @var RouterInterface $router */
        $router = $this->container->get('router');
        $routes = $router->getRouteCollection()->all();

        $excludedRoutes = [Authenticate::API_AUTH_CALLBACK];

        $routes = array_filter($routes, function ($routeName) use ($excludedRoutes) {
            return str_starts_with($routeName, 'api') && !in_array($routeName, $excludedRoutes, true);
        }, ARRAY_FILTER_USE_KEY);

        array_walk($routes, function (&$route, $routeName) {
            $route = [
                'path' => $route->getPath(),
                'method' => $route->getMethods()[0],
            ];
        });
        return $routes;
    }
}
