<?php

namespace Cbase\Cbag3\ArtefactBundle\Tests\Controller;

use Cbase\Cbag3\BaseBundle\Test\WebTestCase;



class ArtefactControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/artefact/');
        $this->assertEquals("artefacte", $crawler->filter('h1')->text());
    }

    public function testNew()
    {
        $client = $this->createClientWithAuthentication('restricted_area');

        $crawler = $client->request('GET', '/artefact/new');
        $this->assertEquals("artefact anlegen", $crawler->filter('h1')->text());
    }

    public function testCreate()
    {
        $client = $this->createClientWithAuthentication('restricted_area');

        $crawler = $client->request('GET', '/artefact/new');
        $form = $crawler->selectButton('c_peichern')->form();
        $form['artefact[name]'] = 'nerdC_leuder';
        $form['artefact[description]'] = 'da stand mal ein gyroscop in der c-base. das waren tolle ceiten';
        $client->submit($form);
        $crawler = $client->followRedirect();
        $this->assertEquals("nerdC_leuder", $crawler->filter('h1')->text());

        $crawler = $client->request('GET', '/artefact/new');
        $form = $crawler->selectButton('c_peichern')->form();
        $form['artefact[name]'] = 'nerdC_leuder';
        $form['artefact[description]'] = 'da stand mal ein gyroscop in der c-base. das waren tolle ceiten';
        $crawler = $client->submit($form);
        $this->assertTrue($crawler->filter('html:contains("This value is already used.")')->count() > 0);
    }

    public function testShow()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/artefact/nerdc-leuder');
        $this->assertEquals("nerdC_leuder", $crawler->filter('h1')->text());

        $client->request('GET', '/artefact/das-artefact-gibt-es-nicht');
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }

    public function testEdit()
    {
        $client = $this->createClientWithAuthentication('restricted_area');

        $client->request('GET', '/artefact/das-artefact-gibt-es-nicht/edit');
        $this->assertEquals(404, $client->getResponse()->getStatusCode());

        $crawler = $client->request('GET', '/artefact/nerdc-leuder/edit');
        $this->assertEquals("nerdC_leuder", $crawler->filter('h1')->text());
    }

    public function testUpdate()
    {
        $client = $this->createClientWithAuthentication('restricted_area');

        $client->request('POST','/artefact/das-artefact-gibt-es-nicht/update');
        $this->assertEquals(404, $client->getResponse()->getStatusCode());

        $crawler = $client->request('GET', '/artefact/nerdc-leuder/edit');
        $form = $crawler->selectButton('c_peichern')->form();
        $form['artefact[description]'] = '';
        $crawler = $client->submit($form);
        $this->assertTrue($crawler->filter('html:contains("This value should not be blank.")')->count() > 0);

//        print_r($client->getResponse()->getContent());

        $crawler = $client->request('GET', '/artefact/nerdc-leuder/edit');
        $form = $crawler->selectButton('c_peichern')->form();
        $form['artefact[name]'] = 'mtc';
        $form['artefact[description]'] = 'multitouchconsole.';
        $client->submit($form);
        $crawler = $client->followRedirect();
        $this->assertEquals("mtc", $crawler->filter('h1')->text());
    }

    public function testManageAssets()
    {
        $client = $this->createClientWithAuthentication('restricted_area');
        $crawler = $client->request('GET', '/artefact/mtc/assets');
    }
}
