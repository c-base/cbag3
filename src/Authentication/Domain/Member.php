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
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use Symfony\Component\Security\Core\Role\RoleHierarchyInterface;
use Symfony\Component\Security\Core\User\UserInterface;

final class Member implements ResourceOwnerInterface, UserInterface
{
    public function __construct(private MemberName $memberName)
    {
    }

    public static function create(MemberName $memberName): static
    {
        return new static($memberName);
    }

    public function getId(): string
    {
        return $this->memberName->value();
    }

    public function toArray(): array
    {
        return ['username' => $this->memberName->value()];
    }

    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    public function eraseCredentials()
    {
    }

    public function getUserIdentifier(): string
    {
        return $this->memberName->value();
    }
}
