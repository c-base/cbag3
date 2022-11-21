<?php

declare(strict_types=1);

namespace Cbase\App\Application\Listener;

use Cbase\Authentication\Application\Controller\Authenticate;
use Cbase\Shared\Domain\FrontendConfig;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\Routing\RouterInterface;

#[AsEventListener]
final class AddResourcesToFrontendConfig
{
    public function __construct(private FrontendConfig $config, private RouterInterface $router)
    {
    }

    public function __invoke(ControllerEvent $event): void
    {
        $routes = $this->router->getRouteCollection()->all();

        $excludedRoutes = [Authenticate::API_AUTH_CALLBACK];

        $routes = array_filter($routes, function ($routeName) use ($excludedRoutes) {
            return str_starts_with($routeName, 'api') && !in_array($routeName, $excludedRoutes, true);
        }, ARRAY_FILTER_USE_KEY);

        $resources = [];
        foreach ($routes as $routeName => $route) {
            $resources[$routeName] = [
                'path' => $route->getPath(),
                'method' => $route->getMethods()[0],
            ];
        }
        $this->config['resources'] = $resources;
    }
}
