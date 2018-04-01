<?php
namespace App\Tests\Base;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\HttpFoundation\Response;

class Then extends Behaviour
{
    public function iExpectStatusIsOk(Client $client)
    {
        $this->testCase->assertTrue($client->getResponse()->isSuccessful(), $client->getResponse()->getStatusCode());
    }

    public function iExpectStatusIsRedirect(Client $client, $statusCode = Response::HTTP_FOUND, $location = null)
    {
        if ($location) {
            $this->testCase->assertEquals($location, $client->getResponse()->headers->get('location'));
        }
        $this->testCase->assertEquals($statusCode, $client->getResponse()->getStatusCode());
    }

    public function iExpectClientError(Client $client, $statusCode = null)
    {
        if ($statusCode) {
            $this->testCase->assertEquals($statusCode, $client->getResponse()->getStatusCode());
        }
        $this->testCase->assertTrue($client->getResponse()->isClientError(), $client->getResponse()->getStatusCode());
    }
}
