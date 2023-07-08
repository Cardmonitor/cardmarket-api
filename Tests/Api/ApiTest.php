<?php

namespace Cardmonitor\Cardmarket\Tests\Api;

use Cardmonitor\Cardmarket\Api;
use Cardmonitor\Cardmarket\Access;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;

class ApiTest extends PHPUnitTestCase
{
    /**
     * @test
     */
    public function it_injects_extra_params()
    {
        $extraParams = [
            'timeout' => 20,
            'some_other' => true,
        ];
        $api = new Api([
            'app_token' => $_ENV['app_token'],
            'app_secret' => $_ENV['app_secret'],
            'access_token' => $_ENV['access_token'],
            'access_token_secret' => $_ENV['access_token_secret'],
            'url' => Api::URL_SANDBOX,
        ], $extraParams);

        // Use a Reflection class to access protected getClient()
        $class = new \ReflectionClass(Access::class);
        $myProtectedMethod = $class->getMethod('getClient');
        $myProtectedMethod->setAccessible(true);

        /*
         * Call the method with arguments on the instance created above
         * Do it for every AbstractApi variable
         */
        $client = $myProtectedMethod->invokeArgs($api->access, ['/path']);
        $this->assertEquals(20, $client->getConfig('timeout'));
        $this->assertEquals(true, $client->getConfig('some_other'));

        $client = $myProtectedMethod->invokeArgs($api->account, ['/path']);
        $this->assertEquals(20, $client->getConfig('timeout'));
        $this->assertEquals(true, $client->getConfig('some_other'));

        $client = $myProtectedMethod->invokeArgs($api->expansion, ['/path']);
        $this->assertEquals(20, $client->getConfig('timeout'));
        $this->assertEquals(true, $client->getConfig('some_other'));

        $client = $myProtectedMethod->invokeArgs($api->games, ['/path']);
        $this->assertEquals(20, $client->getConfig('timeout'));
        $this->assertEquals(true, $client->getConfig('some_other'));

        $client = $myProtectedMethod->invokeArgs($api->messages, ['/path']);
        $this->assertEquals(20, $client->getConfig('timeout'));
        $this->assertEquals(true, $client->getConfig('some_other'));

        $client = $myProtectedMethod->invokeArgs($api->order, ['/path']);
        $this->assertEquals(20, $client->getConfig('timeout'));
        $this->assertEquals(true, $client->getConfig('some_other'));

        $client = $myProtectedMethod->invokeArgs($api->priceguide, ['/path']);
        $this->assertEquals(20, $client->getConfig('timeout'));
        $this->assertEquals(true, $client->getConfig('some_other'));

        $client = $myProtectedMethod->invokeArgs($api->product, ['/path']);
        $this->assertEquals(20, $client->getConfig('timeout'));
        $this->assertEquals(true, $client->getConfig('some_other'));

        $client = $myProtectedMethod->invokeArgs($api->stock, ['/path']);
        $this->assertEquals(20, $client->getConfig('timeout'));
        $this->assertEquals(true, $client->getConfig('some_other'));
    }
}
