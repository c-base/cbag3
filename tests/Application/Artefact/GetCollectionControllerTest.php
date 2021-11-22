<?php
/*
 * (c) 2021 dazz <dazz@c-base.org>
 *
 * For copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace App\Tests\Application\Artefact;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class GetCollectionControllerTest extends WebTestCase
{
    public function testIsRouteReachable()
    {
        $client = self::createClient();
        $response = $client->request(Request::METHOD_HEAD, '/api/artefacts');

        $this->assertResponseIsSuccessful();
    }
}
