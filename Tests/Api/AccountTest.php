<?php

namespace Cardmonitor\Cardmarket\Tests\Api;

class AccountTest extends \Cardmonitor\Cardmarket\Tests\TestCase
{
    /** @test */
    public function getsAccountInformation()
    {
        $data = $this->api->account->get();
        $this->assertArrayHasKey('account', $data);
    }

    /**
     * @test
     */
    public function it_can_log_the_user_out()
    {
        $data = $this->api->account->logout();
        $this->assertEquals('successful', $data['logout']);
    }
}