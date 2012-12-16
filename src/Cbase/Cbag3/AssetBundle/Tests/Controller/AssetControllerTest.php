<?php

namespace Cbase\Cbag3\AssetBundle\Tests\Controller;

use Cbase\Cbag3\BaseBundle\Test\WebTestCase;

class AssetControllerTest extends WebTestCase
{
    public function testCreate()
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
