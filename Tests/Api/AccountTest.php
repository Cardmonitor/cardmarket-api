<?php

namespace Cardmonitor\Cardmarket\Tests\Api;

class AccountTest extends \Cardmonitor\Cardmarket\Tests\TestCase
{
    /** @test */
    public function getsAccountInformation()
    {
        $this->markTestSkipped('Server Error 500.');

        $data = $this->api->account->get();
        $this->assertArrayHasKey('account', $data);
    }

    /**
     * @test
     */
    public function it_can_log_the_user_out()
    {
        $this->markTestSkipped('Server Error 500.');

        $data = $this->api->account->logout();
        $this->assertEquals('successful', $data['logout']);
    }
}