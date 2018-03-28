<?php
namespace App\Tests\Base;

use Symfony\Bundle\FrameworkBundle\Client;

class Then extends Behaviour
{
    public function iExpectStatusIsOk(Client $client)
    {
        $this->testCase->assertTrue($client->getResponse()->isSuccessful());
    }
}
