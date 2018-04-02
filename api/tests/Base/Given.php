<?php
namespace App\Tests\Base;

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\BrowserKit\Cookie;

class Given extends Behaviour
{

    public function iHaveSetupTheDatabase()
    {
        $entityManager = $this->iHaveAnEntityManager();
        $schemaTool = new SchemaTool($entityManager);
        $metadata = $entityManager->getMetadataFactory()->getAllMetadata();

        $schemaTool->dropSchema($metadata);
        $schemaTool->createSchema($metadata);
    }

    public function iHaveLoadedFixtures()
    {
        $loader = new Loader();

        $loader->loadFromDirectory('src/DataFixtures');
        $purger = new ORMPurger();

        $entityManager = $this->iHaveAnEntityManager();
        $executor = new ORMExecutor($entityManager, $purger);
        $executor->execute($loader->getFixtures(), true);
    }

    /**
     * @return EntityManagerInterface
     */
    protected function iHaveAnEntityManager(): EntityManagerInterface
    {
        $this->kernel->boot();
        return $this->kernel->getContainer()->get('doctrine.orm.entity_manager');
    }

    /**
     * @param Client $client
     */
    public function iHaveAnAuthenticatedUser(Client $client)
    {
        $session = $client->getContainer()->get('session');

        // the firewall context defaults to the firewall name
        $firewallContext = 'restricted_area';

        $token = new UsernamePasswordToken('test', null, $firewallContext, array('ROLE_USER'));
        $session->set('_security_'.$firewallContext, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $client->getCookieJar()->set($cookie);
    }
}
