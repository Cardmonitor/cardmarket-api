<?php

namespace Cardmonitor\Cardmarket\Tests\Api;

use Cardmonitor\Cardmarket\Stock;

class StockExportTest extends \Cardmonitor\Cardmarket\Tests\TestCase
{

    /**
     * @test
     */
    public function it_can_create_a_request_to_export_the_stock()
    {
        $data = $this->api->stock_export->create();
    }

    /**
     * @test
     */
    public function it_can_get_the_datails_of_all_export_requests()
    {
        $data = $this->api->stock_export->get();
        $this->assertArrayHasKey('stockExports', $data);
    }
}