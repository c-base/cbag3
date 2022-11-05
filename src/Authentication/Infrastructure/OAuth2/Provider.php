<?php
/*
 * (c) 2022 dazz <dazz@c-base.org>
 *
 * For copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Cbase\Authentication\Infrastructure\OAuth2;

use Cbase\Authentication\Domain\User;
use Cbase\Shared\Domain\MemberName;
use KnpU\OAuth2ClientBundle\Security\User\OAuthUser;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\GenericProvider;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Tool\BearerAuthorizationTrait;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

final class Provider extends GenericProvider
{
    public function __construct(
        string $oauth2ClientId,
        string $oauth2ClientSecret,
        string $oauth2AuthorizationUrl,
        string $oauth2TokenUrl,
        string $oauth2ProfileUrl,
        private string $oauth2Scopes,
        string $oauth2RedirectRoute,
        RouterInterface $router,
    ) {
        parent::__construct([
            'clientId' => $oauth2ClientId,
            'clientSecret' => $oauth2ClientSecret,
            'redirectUri' => $router->generate($oauth2RedirectRoute, [], UrlGeneratorInterface::ABSOLUTE_URL ),
            'urlAuthorize' => $oauth2AuthorizationUrl,
            'urlAccessToken' => $oauth2TokenUrl,
            'urlResourceOwnerDetails' => $oauth2ProfileUrl,
        ]);
    }

    public function getDefaultScopes(): array
    {
        return array_map(fn($scope) => trim($scope), explode(',', $this->oauth2Scopes));
    }

    protected function checkResponse(ResponseInterface $response, $data): void
    {
        if ($response->getStatusCode() !== Response::HTTP_OK) {
            throw new IdentityProviderException($response->getBody(), $response->getStatusCode(), $data);
        }
    }

    protected function createResourceOwner(array $response, AccessToken $token): ResourceOwnerInterface
    {
        return UserProvider::createUser($response['username']);
    }
}
