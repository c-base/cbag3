<?php
namespace App\Tests;

use App\Tests\Base\WebTestCase;

class ApplicationAvailabilityFunctionalTest extends WebTestCase
{
    /**
     * @dataProvider urlProvider
     * @param string $url
     */
    public function testPageIsSuccessful($url)
    {
        $client = self::createClient();

        $this->given->iHaveSetupTheDatabase();
        $this->given->iHaveLoadedFixtures();
        $this->when->iSendARequest($client, 'GET', $url);
        $this->then->iExpectStatusIsOk($client);
    }

    public function urlProvider()
    {
        yield ['/'];
        yield ['/artefacts/'];
        yield ['/artefacts/test-slug'];
    }
}
