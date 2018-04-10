<?php
namespace App\Tests\Base;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\HttpFoundation\Response;

class Then extends Behaviour
{
    public function iExpectStatusIsOk(Client $client, array $headers = [])
    {
        $this->testCase->assertTrue($client->getResponse()->isSuccessful(), $client->getResponse()->getStatusCode());

        foreach ($headers as $header => $value) {
            $this->testCase->assertEquals($value, $client->getResponse()->headers->get($header));
        }
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

    /**
     * @param string $fixtureDir
     * @param string $fixtureName
     * @param string $actual
     * @throws \Exception
     * @uses environment variable FIX_FIXTURES (if set, it updates the fixtures to contain $actualValue)
     */
    public function iExpectItEqualsTheFixture($fixtureDir, $fixtureName, $actual)
    {
        $file = sprintf('%s/%s.%s', $fixtureDir, $fixtureName, 'json');
        if (!file_exists($file)) {
            throw new \Exception(sprintf('Fixture file %s does not exist', $file));
        }

        if (getenv('FIX_FIXTURES')) {
            file_put_contents($file, $actual . "\n");
        }
        $expected = trim(file_get_contents($file));

        $msg = implode("\n", [
            'NOTE: if this difference was expected, re-run phpunit with FIX_FIXTURES=yes, i.e',
            '      FIX_FIXTURES=yes ./vendor/bin/phpunit -c phpunit.xml.dist',
        ]);

        $this->testCase->assertEquals($expected, $actual, $msg);
    }
}
