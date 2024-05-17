<?php

namespace Cardmonitor\Cardmarket\Tests\Api;

class UserOffersExportTest extends \Cardmonitor\Cardmarket\Tests\TestCase
{
    /**
     * @test
     */
    public function it_can_create_a_request_to_export_the_stock()
    {
        $data = $this->api->user_offers_export->create(UserTest::USER_ID);
        var_dump($data);
        $this->assertEquals(202, $data['http_status_code']);
    }

    /**
     * @test
     */
    public function it_can_get_the_request_to_export_for_a_user()
    {
        $data = $this->api->user_offers_export->find(UserTest::USER_ID);
        var_dump($data);
        $this->assertArrayHasKey('userOffersRequests', $data);
    }

    /**
     * @test
     */
    public function it_can_get_the_datails_of_all_export_requests()
    {
        $data = $this->api->user_offers_export->get();
        var_dump($data);
        $this->assertArrayHasKey('userOffersRequests', $data);
    }
}