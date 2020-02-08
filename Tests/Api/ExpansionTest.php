<?php

namespace Cardmonitor\Cardmarket\Tests\Api;

use Cardmonitor\Cardmarket\Expansion;

class ExpansionTest extends \Cardmonitor\Cardmarket\Tests\TestCase
{
    const EXPANSION_ID = 1469;
    const GAME_ID_MAGIC = 1;
    const GAME_ID_YUGIOH = 3;

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

    /**
     * @test
     */
    public function getAllCardsAsCsv()
    {
        $languages = [
            1 => 'English',
            2 => 'French',
            3 => 'German',
            4 => 'Spanish',
            5 => 'Italian',
        ];

        $expansions_count = 0;
        $cards_count = 0;

        $expansionsFile = $this->createExpansionsFile();
        $cardsFile = $this->createSinglesFile();

        $expansions = $this->api->expansion->find(self::GAME_ID_MAGIC);
        foreach ($expansions['expansion'] as $expansion) {
            // var_dump($expansion);
            fputcsv($expansionsFile, $this->transformFromExpansion($expansion), ';');
            $singles = $this->api->expansion->singles($expansion['idExpansion']);
            foreach ($singles['single'] as $key => $single) {
                // var_dump($single);
                fputcsv($cardsFile, $this->transformFromSingle($expansion['idExpansion'], $single), ';');
                $cards_count++;
            }
            $expansions_count++;
        }

        echo 'Fertig' . PHP_EOL;
        echo 'Expansions: ' . $expansions_count . PHP_EOL;
        echo 'Cards: ' . $cards_count . PHP_EOL;
    }

    protected function createExpansionsFile()
    {
        $handle = fopen('expansions.csv', 'wa+');
        fputcsv($handle, [
            'id' => 'ID',
            'language_1' => '1 English',
            'language_2' => '2 French',
            'language_3' => '3 German',
            'language_4' => '4 Spanish',
            'language_5' => '5 Italian',
            'abbreviation' => 'Abbreviation',
            'icon' => 'Icon',
            'release_date' => 'Release Date',
            'is_released' => 'Is Released',
            'abbreviation' => 'Abbreviation',
            'game_id' => 'Game ID',
        ], ';');

        return $handle;
    }

    protected function transformFromExpansion(array $expansion) : array
    {
        return [
            'id' => $expansion['idExpansion'],
            'language_1' => $expansion['localization'][0]['name'],
            'language_2' => $expansion['localization'][1]['name'],
            'language_3' => $expansion['localization'][2]['name'],
            'language_4' => $expansion['localization'][3]['name'],
            'language_5' => $expansion['localization'][4]['name'],
            'abbreviation' => $expansion['abbreviation'],
            'icon' => $expansion['icon'],
            'release_date' => $expansion['releaseDate'],
            'is_released' => $expansion['isReleased'],
            'game_id' => $expansion['idGame'],
        ];
    }

    protected function transformFromSingle(int $expansionId, array $single) : array
    {
        return [
            'expansion_id' => $expansionId,
            'product_id' => $single['idProduct'],
            'meta_product_id' => $single['idMetaproduct'],
            'reprints_count' => $single['countReprints'],
            'language_1' => $single['localization'][0]['name'],
            'language_2' => $single['localization'][1]['name'],
            'language_3' => $single['localization'][2]['name'],
            'language_4' => $single['localization'][3]['name'],
            'language_5' => $single['localization'][4]['name'],
            'website' => $single['website'],
            'image' => $single['image'],
            'game_name' => $single['gameName'],
            'category_name' => $single['categoryName'],
            'game_id' => $single['idGame'],
            'number' => $single['number'] ?? '',
            'rarity' => $single['rarity'],
            'expansion_name' => $single['expansionName'],
            'expansion_icon' => $single['expansionIcon'],
            'articles_count' => $single['countArticles'],
            'articles_foil_count' => $single['countFoils'],
        ];
    }

    protected function createSinglesFile()
    {
        $handle = fopen('cards.csv', 'wa+');
        fputcsv($handle, [
            'expansion_id' => 'Expansion ID',
            'product_id' => 'Product ID',
            'meta_product_id' => 'Metaproduct ID',
            'reprints_count' => 'Reprints Count',
            'language_1' => '1 English',
            'language_2' => '2 French',
            'language_3' => '3 German',
            'language_4' => '4 Spanish',
            'language_5' => '5 Italian',
            'website' => 'Website',
            'image' => 'Image',
            'game_name' => 'Game Name',
            'category_name' => 'Category Name',
            'game_id' => 'Game ID',
            'number' => 'Number',
            'rarity' => 'Rarity',
            'expansion_name' => 'Expansion Name',
            'expansion_icon' => 'Expansion Icon',
            'articles_count' => 'Articles Count',
            'articles_foil_count' => 'Article Foil Count',
        ], ';');

        return $handle;
    }
}