<?php

namespace Cardmonitor\Cardmarket\Tests\Api;

use Cardmonitor\Cardmarket\Expansion;

class ExpansionTest extends \Cardmonitor\Cardmarket\Tests\TestCase
{
    const EXPANSION_ID = 1469;
    const GAME_ID_MAGIC = 1;

    /** @test */
    public function findsAllExpansionsForAGame()
    {
        $data = $this->api->expansion->find(self::GAME_ID_MAGIC);
        var_dump($data['expansion']);
        $this->assertArrayHasKey('expansion', $data);
        $this->assertArrayHasKey('links', $data);
    }

    /** @test */
    public function getsAllSinglesForAnExtension()
    {
        $data = $this->api->expansion->singles(self::EXPANSION_ID);

        $this->assertArrayHasKey('expansion', $data);
        $this->assertArrayHasKey('single', $data);
    }
}