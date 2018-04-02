<?php
/*
 * (c) 2018 dazz <dazz@c-base.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tests\Functional;

use App\Tests\Base\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class SecurityIsTurnedOnTest extends WebTestCase
{

    public function testChangingMethodsAreProtected()
    {
        $client = self::createClient();

        $this->when->iSendARequest($client, 'POST', '/artefacts/');
        $this->then->iExpectClientError($client);
    }

    public function testLoginTheUserWithWrongCredentials()
    {
        $client = self::createClient();

        $content = json_encode([
            "_username" => "test",
            "_password" => "wrongpassword",
        ]);

        $this->when->iSendARequest(
            $client,
            'POST',
            '/login',
            [],
            [],
            $content
        );
        $this->then->iExpectClientError($client, Response::HTTP_UNAUTHORIZED);
    }

    public function testLoginTheUser()
    {
        $client = self::createClient();

        $this->when->iSendALoginRequest($client);
        $this->then->iExpectStatusIsOk($client);
    }
}
