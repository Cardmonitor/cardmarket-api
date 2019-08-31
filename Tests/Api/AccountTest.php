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
}