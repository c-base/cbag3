<?php
namespace App\Tests\Base;

use Symfony\Bundle\FrameworkBundle\Client;

class When extends Behaviour
{
    public function iSendARequest(Client $client, $method, $uri, array $parameters = [], array $files = [], array $server = [])
    {
        $client->request($method, $uri, $parameters, $files, $server);
    }
}
