<?php

declare(strict_types=1);

namespace Cbase\App\Application\Listener;

use Cbase\App\Domain\FrontendConfig;
use Cbase\Authentication\Application\Controller\Authenticate;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\Routing\RouterInterface;

#[AsEventListener]
final class AddFrontendConfig
{
    public function __construct(private FrontendConfig $config, private RouterInterface $router)
    {
    }

    public function __invoke(ControllerEvent $event)
    {
        /** @var RouterInterface $router */
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
        $this->config->addConfig('resources', $resources);
    }
}
