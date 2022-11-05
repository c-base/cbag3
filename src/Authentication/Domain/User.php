<?php
/*
 * (c) 2022 dazz <dazz@c-base.org>
 *
 * For copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Cbase\Authentication\Domain;

use Cbase\Shared\Domain\MemberName;
use KnpU\OAuth2ClientBundle\Security\User\OAuthUser;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use Symfony\Component\Security\Core\Role\RoleHierarchyInterface;
use Symfony\Component\Security\Core\User\UserInterface;

final class User extends OAuthUser implements ResourceOwnerInterface
{
    public function getId(): string
    {
        return $this->getUserIdentifier();
    }

    public function toArray(): array
    {
        return ['username' => $this->getUserIdentifier()];
    }
}
