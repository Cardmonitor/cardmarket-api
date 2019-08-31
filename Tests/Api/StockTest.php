<?php

namespace Cardmonitor\Cardmarket\Tests\Api;

class StockTest extends \Cardmonitor\Cardmarket\Tests\TestCase
{

    const VALID_PRODUCT_ID = 265535;

    /** @test */
    public function getsAllStock()
    {
        $data = $this->api->stock->get();
        $this->assertArrayHasKey('article', $data);
    }

    /** @test */
    public function getOneArticle()
    {
        $article = [
            'idProduct' => self::VALID_PRODUCT_ID,
            'idLanguage' => 1,
            'comments' => 'Inserted through the API',
            'count' => 1,
            'price' => 4,
            'condition' => 'EX',
        ];

        $data = $this->api->stock->add($article);

        $stocks = $this->api->stock->get();
        $stock = $stocks['article'][0];

        $data = $this->api->stock->article($stock['idArticle']);
        var_dump($data);
        $this->assertArrayHasKey('article', $data);
    }

    /** @test */
    public function addsOneArticle()
    {
        $article = [
            'idProduct' => self::VALID_PRODUCT_ID,
            'idLanguage' => 1,
            'comments' => 'Inserted through the API',
            'count' => 1,
            'price' => 2.34,
            'condition' => 'EX',
        ];

        $data = $this->api->stock->add($article);

        $stock = $this->api->stock->get();
        $this->showStock($stock);
    }

    protected function showStock(array $stock)
    {
        echo PHP_EOL;
        echo "Article ID\tProduct ID\tAnzahl\tPreis\tKommentar" . PHP_EOL;
        foreach ($stock['article'] as $article) {
            echo $article['idArticle'] . "\t" . $article['idProduct'] . "\t\t" . $article['count'] . "\t" . $article['price'] . "\t" . $article['comments'] . PHP_EOL;
        }
    }

    /** @test */
    public function updatesExistingArticle()
    {
        $stocks = $this->api->stock->get();
        $stock = $stocks['article'][0];

        $article = [
            'idArticle' => 360675047,
            'idLanguage' => 1,
            'comments' => 'Edited through the API',
            'count' => 1,
            'price' => 1.24,
            'condition' => 'NM',
        ];

        $data = $this->api->stock->update($article);
        var_dump($data);
        $stock = $this->api->stock->get();
        $this->showStock($stock);
    }

    /** @test */
    public function updatesOneArticle()
    {
        $article = [
            'idProduct' => self::VALID_PRODUCT_ID,
            'idLanguage' => 1,
            'comments' => 'Inserted through the API',
            'count' => 1,
            'price' => 4,
            'condition' => 'EX',
        ];

        $data = $this->api->stock->add($article);

        $stocks = $this->api->stock->get();
        $stock = $stocks['article'][0];

        $article = [
            'idArticle' => $stock['idArticle'],
            'idLanguage' => 1,
            'comments' => 'Edited through the API',
            'count' => 1,
            'price' => 1.23,
            'condition' => 'NM',
        ];

        $data = $this->api->stock->update($article);
    }

    /** @test */
    public function changesTheQuantityArticle()
    {
        $article = [
            'idProduct' => self::VALID_PRODUCT_ID,
            'idLanguage' => 1,
            'comments' => 'Inserted through the API',
            'count' => 1,
            'price' => 4,
            'condition' => 'EX',
        ];

        $data = $this->api->stock->add($article);

        $stocks = $this->api->stock->get();
        $stock = $stocks['article'][0];
        $count = $stock['count'];

        $article = [
            'idArticle' => $stock['idArticle'],
            'amount' => 1,
        ];
        $data = $this->api->stock->increase($article);

        $stock = $this->api->stock->article($stocks['article'][0]['idArticle']);
        $this->assertEquals(($count + 1), $stock['article']['count']);

        $data = $this->api->stock->decrease($article);

        $stock = $this->api->stock->article($stocks['article'][0]['idArticle']);
        $this->assertEquals($count, $stock['article']['count']);

    }

    /** @test */
    public function getsCsv()
    {
        $data = $this->api->stock->csv();
        $filename = 'stock.csv';
        $zippedFilename = $filename . '.gz';

        $handle = fopen($zippedFilename, 'wa+');
        fwrite( $handle, base64_decode( $data['stock'] ) );
        fclose( $handle );

        $this->assertFileExists($zippedFilename);

        shell_exec('gunzip ' . $filename);

        $this->assertFileExists($filename);

        unlink($filename);
        unlink($zippedFilename);
    }

    /** @test */
    public function deletesOneArticle()
    {
        $articles = [];

        $stocks = $this->api->stock->get();
        $article = $stocks['article'][0];
        $articles[] = [
            'idArticle' => $stocks['article'][0]['idArticle'],
            'count' => 1,
        ];

        $data = $this->api->stock->delete($articles);

        $article = $this->api->stock->article($stocks['article'][0]['idArticle']);
        var_dump($article);
    }

    /** @test */
    public function deletesAllArticles()
    {
        $articles = [];

        $stocks = $this->api->stock->get();

        foreach ($stocks['article'] as $key => $stock) {
            $articles[] = [
                'idArticle' => $stock['idArticle'],
                'count' => $stock['count'],
            ];
        }

        $data = $this->api->stock->delete($articles);

        $stocks = $this->api->stock->get();
        $this->assertCount(0, $stocks['article']);
    }


}