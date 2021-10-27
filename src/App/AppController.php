<?php

namespace App\App;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

class AppController extends AbstractController
{
    /**
     * @Route("/{reactRouting}",
     *     name="app_index",
     *     priority="-1",
     *     defaults={"reactRouting": null},
     *     requirements={"reactRouting"=".+"}
     * )
     */
    public function index(): Response
    {
        $config = [
            'user' => null,
            'resources' => $this->getApiResources(),
        ];
        return $this->render('app/index.html.twig', [
            'config' => json_encode($config),
        ]);
    }

    /**
     * @return array
     */
    private function getApiResources(): array
    {
        /** @var RouterInterface $router */
        $router = $this->container->get('router');
        $routes = $router->getRouteCollection()->all();
        $routes = array_filter($routes, function ($routeName) {
            return str_starts_with($routeName, 'api');
        }, ARRAY_FILTER_USE_KEY);

        array_walk($routes, function(&$route, $routeName) {
            $route = [
                'path' => $route->getPath(),
                'method' => $route->getMethods()[0],
            ];
        });
        return $routes;
    }
}
