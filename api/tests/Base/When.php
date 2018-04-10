<?php
namespace App\Tests\Base;

use Symfony\Bundle\FrameworkBundle\Client;

class When extends Behaviour
{
    public function iSendARequest(Client $client, $method, $uri, $parameters = [], array $server = [], $content = null)
    {
        $server['CONTENT_TYPE'] = 'application/json';
        $server['HTTP_ACCEPT'] = 'application/json';

        $client->request($method, $uri, $parameters, [], $server, $content);
    }

    public function iSendALoginRequest(Client $client)
    {
        $content = json_encode([
            "_username" => "test",
            "_password" => "test",
        ]);

        $this->iSendARequest($client, 'POST', '/login', [], [], $content);
    }
}
