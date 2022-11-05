<?php
/*
 * (c) 2022 dazz <dazz@c-base.org>
 *
 * For copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Cbase\Authentication\Infrastructure\OAuth2;

use KnpU\OAuth2ClientBundle\Client\OAuth2Client;
use League\OAuth2\Client\Provider\AbstractProvider;
use Symfony\Component\HttpFoundation\RequestStack;

final class Client extends OAuth2Client
{
    public function __construct(Provider $provider, RequestStack $requestStack)
    {
        parent::__construct($provider, $requestStack);
    }
}
