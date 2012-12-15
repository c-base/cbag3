<?php

namespace Cbase\Cbag3\BaseBundle\Test;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase as BaseWebTestCase;

use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Session\Session;

abstract class WebTestCase extends BaseWebTestCase
{

    public static function tearDownAfterClass()
    {
        $conn = static::createClient()
            ->getContainer()
            ->get('doctrine.odm.mongodb.default_connection');
        $conn->connect();
        $defaultDB = $conn->getConfiguration()->getDefaultDB();
        $conn->dropDatabase($defaultDB);
        $conn->close();
        unset($conn);
    }

    /**
     * Create Client with logged in user
     *
     * @param $firewallName
     * @param array $options
     * @param array $server
     *
     * @return \Symfony\Component\BrowserKit\Client
     */
    protected function createClientWithAuthentication($firewallName, array $options = array(), array $server = array())
    {
        /* @var $client \Symfony\Component\BrowserKit\Client */
        $client = static::createClient($options, $server);

        return $this->getClientWithAuthentication($client, $firewallName, $options, $server);
    }

    protected function getClientWithAuthentication($client, $firewallName, array $options = array(), array $server = array())
    {
        $session = $client->getContainer()->get('session');
        // Since the namespace of the session changed in symfony 2.1, instanceof can be used to check the version.
        if ($session instanceof Session) {
            $session->setId(uniqid());
        }

        $client->getCookieJar()->set(new Cookie('MOCKSESSID', $session->getId()));

        $token = new UsernamePasswordToken($this->getMockUser(), null, $firewallName, array('ROLE_CREW'));

        $client->getContainer()->get('security.context')->setToken($token);
        $session->set('_security_' . $firewallName, serialize($token));

        $session->save();

        return $client;
    }

    protected function getMockUser()
    {
        $user = new \Symfony\Component\Security\Core\User\User(
            'testuser',
            'test',
            array('ROLE_CREW')
        );
        return $user;
    }
}