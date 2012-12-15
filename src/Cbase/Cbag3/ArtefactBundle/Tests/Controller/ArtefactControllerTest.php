<?php

namespace Cbase\Cbag3\ArtefactBundle\Tests\Controller;

use Cbase\Cbag3\BaseBundle\Test\WebTestCase;



class ArtefactControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/artefact/');

        $this->assertTrue($crawler->filter('html:contains("artefacte")')->count() > 0);

        $this->assertGreaterThan(0, $crawler->filter('div#artefact_list')->count());
    }

    public function testNew()
    {
        $client = $this->createClientWithAuthentication('restricted_area');

        $crawler = $client->request('GET', '/artefact/new');

        $this->assertTrue($crawler->filter('html:contains("artefact anlegen")')->count() > 0);
        $this->assertTrue($crawler->filter('h1')->count() > 0);
    }

    public function testCreateNewArtefact()
    {
        $client = $this->createClientWithAuthentication('restricted_area');

        $crawler = $client->request('GET', '/artefact/new');
        $form = $crawler->selectButton('c_peichern')->form();

        $form['artefact[name]'] = 'nerdC_leuder';
        $form['artefact[description]'] = 'da stand mal ein gyroscop in der c-base. das waren tolle ceiten';

        $client->submit($form);
        $crawler = $client->followRedirect();

        $this->assertTrue($crawler->filter('html:contains("nerdC_leuder")')->count() > 0);

        $crawler = $client->request('GET', '/artefact/nerdc-leuder');
        $this->assertTrue($crawler->filter('html:contains("nerdC_leuder")')->count() > 0);
    }

   public function testClickArtefact()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/artefact/');

        $firstArtefactNode = $crawler->filter('#artefact_list')
            ->children()
            ->first()
            ->filter('a')
            ->eq(0)
        ;

        /**@var \Symfony\Component\DomCrawler\Link $link*/
        $link = $firstArtefactNode->link();

        $client->click($link);

        $this->assertGreaterThan(0, $crawler->filter('h1')->count());
    }

    public function testArtefactNotFound()
    {
        $client = static::createClient();
        $client->request('GET', '/artefact/das-artefact-gibt-es-nicht');

        $this->assertEquals(
            404,
            $client->getResponse()->getStatusCode()
        );
    }
}
