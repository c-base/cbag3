<?php

namespace App\App;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

class AppController extends AbstractController
{
    /**
     * @Route("/", name="app_index")
     */
    public function index(): Response
    {
        $config = [
            'user' => null,
            'resources' => $this->getResources(),
        ];
        return $this->render('app/index.html.twig', [
            'config' => json_encode($config),
        ]);
    }

    /**
     * @return array
     */
    private function getResources(): array
    {
        /** @var RouterInterface $router */
        $router = $this->container->get('router');
        $routes = $router->getRouteCollection()->all();
        $routes = array_filter($routes, function ($routeName) {
            if (str_starts_with($routeName, '_') || str_starts_with($routeName, 'admin')) {
                return false;
            }
            return true;
        }, ARRAY_FILTER_USE_KEY);

        array_walk($routes, function(&$route, $routeName) {
            $route = [
                'name' => $routeName,
                'path' => $route->getPath(),
                'methods' => $route->getMethods(),
            ];
        });
        return $routes;
    }
}
