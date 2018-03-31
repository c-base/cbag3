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
    /**
     * @expectedException \Symfony\Component\Security\Core\Exception\InsufficientAuthenticationException
     * @expectedExceptionMessage Full authentication is required to access this resource.
     */
    public function testChangingMethodsAreProtected()
    {
        $client = self::createClient();

        $this->when->iSendARequest($client, 'POST', '/artefacts/');
    }

    public function testLoginTheUserWithWrongCredentials()
    {
        $client = self::createClient();

        $content = json_encode([
            "_username" => "test",
            "_password" => "wrongpassword",
        ]);

        $headers = [
            "CONTENT_TYPE" => "application/json",
            'HTTP_ACCEPT' => 'application/json'
        ];

        $this->when->iSendARequest(
            $client,
            'POST',
            '/login',
            [],
            $headers,
            $content
        );
        $this->then->iExpectClientError($client, Response::HTTP_UNAUTHORIZED);
    }

    public function testLoginTheUser()
    {
        $client = self::createClient();

        $this->given->iHaveAnAuthenticatedUser($client);
        $this->then->iExpectStatusIsOk($client);
    }
}
