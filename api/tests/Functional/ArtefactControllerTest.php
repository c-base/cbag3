<?php
/*
 * (c) 2018 dazz <dazz@c-base.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace App\Tests\Functional;

use App\Entity\Artefact;
use App\Tests\Base\WebTestCase;

class ArtefactControllerTest extends WebTestCase
{
    public function testCreateArtefactSuccessful()
    {
        $client = self::createClient();

        $artefact = new Artefact('hallo welt', null, 'a good description');

        $serializer = $client->getContainer()->get('serializer');
        $artefact = $serializer->serialize($artefact, 'json');

        $this->given->iHaveAnAuthenticatedUser($client);
        $this->when->iSendARequest($client, 'POST', '/artefacts/', [], [], $artefact);
        $this->then->iExpectStatusIsOk($client, ['location' => 'http://localhost/artefacts/hallo-welt']);

        // now we follow the location header
        $this->when->iSendARequest($client, 'GET', '/artefacts/hallo-welt');

        $artefactCreated = json_decode($client->getResponse()->getContent(), true);
        unset($artefactCreated['createdAt']);
        $artefactCreated = json_encode($artefactCreated, JSON_PRETTY_PRINT);
        $this->then->iExpectItEqualsTheFixture(
            __DIR__ . '/fixtures',
            'response.artefact.item',
            $artefactCreated
        );
    }
}
