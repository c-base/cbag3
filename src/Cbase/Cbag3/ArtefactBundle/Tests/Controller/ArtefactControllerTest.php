<?php

namespace Cbase\Cbag3\ArtefactBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Session\Session;
use Cbase\Cbag3\BaseBundle\Test\User;

class ArtefactControllerTest extends WebTestCase
{

//    private $token;
//
//    public function testIndex()
//    {
//        $client = static::createClient();
//
//        $crawler = $client->request('GET', '/artefact/');
//
//        $this->assertTrue($crawler->filter('html:contains("artefacte")')->count() > 0);
//
//        $this->assertGreaterThan(0, $crawler->filter('div#artefact_list')->count());
//    }
//
//    public function testClickArtefact()
//    {
//        $client = static::createClient();
//        $crawler = $client->request('GET', '/artefact/');
//
//        $firstArtefactNode = $crawler->filter('#artefact_list')
//            ->children()
//            ->first()
//            ->filter('a')
//            ->eq(0)
//        ;
//
//        /**@var \Symfony\Component\DomCrawler\Link $link*/
//        $link = $firstArtefactNode->link();
//
//        $client->click($link);
//
//        $this->assertGreaterThan(0, $crawler->filter('h1')->count());
//    }
//
//    public function testShow()
//    {
//        $client = static::createClient();
//
//        $crawler = $client->request('GET', '/artefact/mtc');
//
//        $this->assertTrue($crawler->filter('html:contains("mtc")')->count() > 0);
//    }

    public function testNew()
    {
        $client = $this->createClientWithAuthentication('restricted_area');

        $crawler = $client->request('GET', '/artefact/new');

//        print_r($client->getResponse()->getContent());

        $this->assertTrue($crawler->filter('html:contains("artefact anlegen")')->count() > 0);
        $this->assertTrue($crawler->filter('h1')->count() > 0);
    }

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
