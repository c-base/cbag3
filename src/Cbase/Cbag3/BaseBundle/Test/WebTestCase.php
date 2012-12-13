<?php

namespace Cbase\Cbag3\BaseBundle\Test;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase as BaseWebTestCase;

use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Session\Session;

abstract class WebTestCase extends BaseWebTestCase
{
    protected function createClientWithAuthentication($firewallName, array $options = array(), array $server = array())
    {
        /* @var $client \Symfony\Component\BrowserKit\Client */
        $client = static::createClient($options, $server);

        $session = $client->getContainer()->get('session');
        // Since the namespace of the session changed in symfony 2.1, instanceof can be used to check the version.
        if ($session instanceof Session) {
            $session->setId(uniqid());
        }

        $client->getCookieJar()->set(new Cookie('MOCKSESSID', $session->getId()));

        $token = new UsernamePasswordToken('dazz', null, $firewallName, array('ROLE_CREW'));

        $client->getContainer()->get('security.context')->setToken($token);
        $session->set('_security_' . $firewallName, serialize($token));

        $session->save();

        return $client;
    }
}