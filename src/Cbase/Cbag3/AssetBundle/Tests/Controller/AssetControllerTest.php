<?php

namespace Cbase\Cbag3\AssetBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AssetControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/asset/');

        $this->assertTrue($crawler->filter('html:contains("grafic_e darstellungen")')->count() > 0);
    }
}
