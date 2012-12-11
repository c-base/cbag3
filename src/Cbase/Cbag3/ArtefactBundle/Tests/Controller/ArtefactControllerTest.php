<?php

namespace Cbase\Cbag3\ArtefactBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ArtefactControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/artefact/');

        $this->assertTrue($crawler->filter('html:contains("artefacte")')->count() > 0);

        $this->assertGreaterThan(0, $crawler->filter('div#artefact_list')->count());
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

    public function testArtefactShow()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/artefact/mtc');

        $this->assertTrue($crawler->filter('html:contains("mtc")')->count() > 0);
    }
}
