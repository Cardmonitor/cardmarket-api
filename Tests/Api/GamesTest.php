<?php

namespace Cardmonitor\Cardmarket\Tests\Api;

use Cardmonitor\Cardmarket\Product;
use GuzzleHttp\Client;

class GamesTest extends \Cardmonitor\Cardmarket\Tests\TestCase
{
    /**
     * @test
     */
    public function getsGames()
    {
        $data = $this->api->games->get();
        $this->assertArrayHasKey('game', $data);
    }



}