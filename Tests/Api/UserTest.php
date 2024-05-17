<?php

namespace Cardmonitor\Cardmarket\Tests\Api;

class UserTest extends \Cardmonitor\Cardmarket\Tests\TestCase
{
    public const USER_ID = 10000;
    public const USERNAME = 'karmacrow';

    /**
     * @test
     */
    public function it_can_find_a_user_by_id()
    {
        $data = $this->api->user->findById(self::USER_ID);
        var_dump($data);
        $this->assertArrayHasKey('user', $data);
        $this->assertEquals(self::USER_ID, $data['user']['idUser']);
    }

    /**
     * @test
     */
    public function it_can_find_a_user_by_username()
    {
        $data = $this->api->user->findByName(self::USERNAME);
        var_dump($data);
        $this->assertArrayHasKey('user', $data);
        $this->assertEquals(self::USER_ID, $data['user']['idUser']);
    }
}