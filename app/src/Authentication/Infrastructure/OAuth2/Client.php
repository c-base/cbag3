<?php

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
