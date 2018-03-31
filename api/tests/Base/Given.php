<?php
namespace App\Tests\Base;

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\Client;

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
    public function iHaveAnAuthenticatedUser(Client $client): void
    {
        $server = [
            "CONTENT_TYPE" => "application/json",
            'HTTP_ACCEPT' => 'application/json'
        ];

        $content = json_encode([
            "_username" => "test",
            "_password" => "test",
        ]);

        $client->request('POST','/login', [], [], $server, $content);
    }
}
