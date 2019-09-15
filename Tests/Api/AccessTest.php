<?php

namespace Cardmonitor\Cardmarket\Tests\Api;

class AccessTest extends \Cardmonitor\Cardmarket\Tests\TestCase
{
    /**
     * @test
     */
    public function it_gets_the_login_link()
    {
        echo $this->api->access->link();
        $this->assertEquals($this->accessData['url'] . '/ws/v2.0/authenticate/' . $this->accessData['app_token'] . '/de', $this->api->access->link());
    }

    /**
     * @test
     */
    public function it_gets_the_access_token_and_access_token_secret()
    {
        $data = $this->api->access->token($this->accessData['request_token']);

        var_dump($data);
        $this->assertArrayHasKey('oauth_token', $data);
        $this->assertArrayHasKey('oauth_token_secret', $data);
        $this->assertArrayHasKey('account', $data);
    }
}