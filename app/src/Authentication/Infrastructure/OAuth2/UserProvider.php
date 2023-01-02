<?php

declare(strict_types=1);

namespace Cbase\Authentication\Infrastructure\OAuth2;

use Cbase\Authentication\Domain\User;
use KnpU\OAuth2ClientBundle\Security\User\OAuthUser;
use KnpU\OAuth2ClientBundle\Security\User\OAuthUserProvider;

final class UserProvider extends OAuthUserProvider
{
    public static function createUser(string $username): User
    {
        return new User($username, ['ROLE_USER', 'ROLE_OAUTH_USER']);
    }

    public function supportsClass($class): bool
    {
        return User::class === $class || OAuthUser::class === $class;
    }
}
