<?php

namespace Cbase\Cbag3\AssetBundle\Tests\Controller;

use Cbase\Cbag3\BaseBundle\Test\WebTestCase;

class AssetControllerTest extends WebTestCase
{
    public function testCreate()
    {
        $client = $this->uploadAsset();
        $crawler = $client->followRedirect();

        $this->assertTrue($crawler->filter('html:contains("neue grafic wurde in den speicher aufgenommen")')->count() > 0);
    }

    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/asset/');

        $this->assertEquals("grafic_e darstellungen", $crawler->filter('h1')->text());
    }
}
