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
        var_dump(basename($data['single'][100]['website']));

    }

    /** @test */
    public function getAllCards()
    {
        $expansions = $this->api->expansion->find(self::GAME_ID_MAGIC);

        $file = fopen('singles.csv', 'w');
        fputcsv($file, [
            'Dateiname',
            'Pfad'
        ], ';');

        foreach ($expansions['expansion'] as $expansion) {
            $expansionId = $expansion['idExpansion'];
            $expansionName = $expansion['enName'];
            $expansionAbbreviation = $expansion['abbreviation'];

            echo $expansionName . ' (' . $expansionAbbreviation . ')' . PHP_EOL;
            $singles = $this->api->expansion->singles($expansionId);
            foreach ($singles['single'] as $key => $single) {
                $imagePath = $single['image'];
                $slug = strtolower(basename($single['website']));
                $number = $single['number'];

                fputcsv($file, [
                    strtolower($expansionAbbreviation) . '-' . $number . '-' . $slug . '.jpg',
                    'https://static.cardmarket.com' . substr($imagePath, 1),
                ], ';');
            }
        }

        fclose($file);
    }
}