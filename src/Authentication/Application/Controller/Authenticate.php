<?php

declare(strict_types=1);

namespace Cbase\Authentication\Application\Controller;

use Cbase\Authentication\Domain\User;
use Cbase\Authentication\Infrastructure\OAuth2\Client;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
final class Authenticate extends AbstractController
{
    public const API_AUTH_CBASE = 'api_auth_cbase';
    public const API_AUTH_CALLBACK = 'api_auth_callback';

    /**
     * Link to this controller to start the 'connect' process
     */
    #[Route(path: '/api/auth/c-base', name: self::API_AUTH_CBASE, methods: [Request::METHOD_GET])]
    public function connect(Client $client): RedirectResponse
    {
        return $client->redirect();
    }

    /**
     * After going to c-base, you're redirected back here
     * because this is the "redirect_route" you configured
     * in config/packages/knpu_oauth2_client.yaml
     */
    #[Route(path: '/api/auth/callback', name: self::API_AUTH_CALLBACK, methods: [Request::METHOD_GET])]
    public function connectCheckAction(Request $request, Client $client): RedirectResponse
    {
        return new RedirectResponse('/');
    }
}
