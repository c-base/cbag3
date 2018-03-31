<?php
namespace App\Tests\Base;

use Symfony\Bundle\FrameworkBundle\Client;

class When extends Behaviour
{
    public function iSendARequest(Client $client, $method, $uri, $parameters = [], array $server = [], $content = null)
    {
        $client->request($method, $uri, $parameters, [], $server, $content);
    }
}
