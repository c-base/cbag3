<?php

namespace Cbase\Cbag3\BaseBundle\Test;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase as BaseWebTestCase;

use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Session\Session;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Config\Definition\Exception\Exception;

abstract class WebTestCase extends BaseWebTestCase
{

    /**
     * Cleans up all the touched resources
     */
    public static function setUpBeforeClass()
    {
        $container = static::createClient()
            ->getContainer();
        self::cleanUpDatabase($container);
        self::cleanUpAssetUploadDir($container);
    }

    private static function cleanUpDatabase($container)
    {
        $conn = $container
            ->get('doctrine_mongodb.odm.default_connection');
        $conn->connect();
        $defaultDB = $conn->getConfiguration()->getDefaultDB();
        $conn->dropDatabase($defaultDB);
        $conn->close();
        unset($conn);
    }

    private static function cleanUpAssetUploadDir($container)
    {
        $upload_dir_config = $container->getParameter('cbase_cbag3_asset.upload_dir');
        if (!$upload_dir_config) {
            throw new Exception('config value "cbase_cbag3_asset.upload_dir" is not set');
            die();
        }
        $upload_dir = __DIR__.'/../../../../../web/'.$upload_dir_config;

        $filesystem = new Filesystem();
        if ($filesystem->exists($upload_dir)) {
            $filesystem->remove($upload_dir);
        }
        $filesystem->mkdir($upload_dir);
    }

    protected function uploadAsset()
    {
        $client = $this->createClientWithAuthentication('restricted_area');
        $crawler = $client->request('GET', '/asset/new');
        $form = $crawler->selectButton('c_peichern')->form();

        $image = __DIR__.'/../Resources/public/images/are_you_happy.jpg';

        $form['artefact_asset[description]'] = 'are you happy';
        $form['artefact_asset[author]'] = 'mr. testuser himself';
        $form['artefact_asset[licence]']->select('CC-BY-SA');
        $form['artefact_asset[file]']->upload($image);

        $client->submit($form);

        return $client;
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