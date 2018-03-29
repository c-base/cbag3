<?php
namespace App\Tests\Base;

use Symfony\Bundle\FrameworkBundle\Client;

class Then extends Behaviour
{
    public function iExpectStatusIsOk(Client $client)
    {
        $this->testCase->assertTrue($client->getResponse()->isSuccessful(), $client->getResponse()->getStatusCode());
    }

    public function iExpectClientError(Client $client, $statusCode = false)
    {
        if ($statusCode) {
            $this->testCase->assertEquals($statusCode, $client->getResponse()->getStatusCode());
        }
        $this->testCase->assertTrue($client->getResponse()->isClientError(), $client->getResponse()->getStatusCode());
    }
}
