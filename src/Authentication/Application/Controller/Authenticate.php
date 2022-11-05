<?php
/*
 * (c) 2022 dazz <dazz@c-base.org>
 *
 * For copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Cbase\Authentication\Application\Controller;

use Cbase\Authentication\Domain\Member;
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
    const API_AUTH_CBASE = 'api_auth_cbase';
    const API_AUTH_CALLBACK = 'api_auth_callback';

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
    #[Route(path: '/api/auth/callback', name: self::API_AUTH_CALLBACK)]
    public function connectCheckAction(Request $request, Client $client)
    {
        dd($request);
        // ** if you want to *authenticate* the user, then
        // leave this method blank and create a Guard authenticator
        // (read below)

        try {
            // the exact class depends on which provider you're using
            /** @var Member $user */
            $user = $client->fetchUser();

            // do something with all this new power!
            // e.g. $name = $user->getFirstName();
            var_dump($user); die;
            // ...
        } catch (IdentityProviderException $e) {
            // something went wrong!
            // probably you should return the reason to the user
            var_dump($e->getMessage()); die;
        }
    }

}
