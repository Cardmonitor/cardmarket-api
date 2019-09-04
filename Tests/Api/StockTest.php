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
        $this->showStock($data);
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

        $this->assertArrayHasKey('inserted', $data);
        $this->assertEquals('true', $data['inserted']['success']);

        $article['idArticle'] = $data['inserted']['idArticle']['idArticle'];
        $this->api->stock->delete($article);
    }

    /** @test */
    public function addsTwoArticles()
    {
        $articles = [
            [
                'idProduct' => self::VALID_PRODUCT_ID,
                'idLanguage' => 1,
                'comments' => 'Inserted through the API',
                'count' => 1,
                'price' => 0.02,
                'condition' => 'EX',
            ],
            [
                'idProduct' => self::VALID_PRODUCT_ID,
                'idLanguage' => 1,
                'comments' => 'Inserted through the API',
                'count' => 1,
                'price' => 0.02,
                'condition' => 'EX',
            ],
        ];

        $data = $this->api->stock->add($articles);

        $this->assertArrayHasKey('inserted', $data);
        $this->assertEquals('true', $data['inserted'][0]['success']);
        $this->assertEquals('true', $data['inserted'][1]['success']);
        $this->assertCount(2, $data['inserted']);

        foreach ($articles as $key => $article) {
            $articles[$key]['idArticle'] = $data['inserted'][$key]['idArticle']['idArticle'];
        }
        $this->api->stock->delete($articles);
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
    public function updatesOneArticle()
    {
        $article = [
            'idProduct' => self::VALID_PRODUCT_ID,
            'idLanguage' => 1,
            'comments' => 'Inserted through the API',
            'count' => 1,
            'price' => 1,
            'condition' => 'EX',
        ];

        $data = $this->api->stock->add($article);
        $newArticleId = $data['inserted']['idArticle']['idArticle'];

        $article = [
            'idArticle' => $newArticleId,
            'idLanguage' => 1,
            'comments' => 'Edited through the API',
            'count' => 1,
            'price' => 1.23,
            'condition' => 'NM',
        ];

        $updatedArticle = $this->api->stock->update($article);
        $this->assertArrayHasKey('updatedArticles', $updatedArticle);
        $this->assertArrayHasKey('notUpdatedArticles', $updatedArticle);

        $article['idArticle'] = $updatedArticle['updatedArticles']['idArticle'];
        $this->api->stock->delete($article);
    }

    /** @test */
    public function updatesTwoArticles()
    {
        $articles = [
            [
                'idProduct' => self::VALID_PRODUCT_ID,
                'idLanguage' => 1,
                'comments' => 'Inserted through the API',
                'count' => 1,
                'price' => 0.02,
                'condition' => 'EX',
            ],
            [
                'idProduct' => self::VALID_PRODUCT_ID,
                'idLanguage' => 1,
                'comments' => 'Inserted through the API',
                'count' => 1,
                'price' => 0.02,
                'condition' => 'EX',
            ],
        ];

        $data = $this->api->stock->add($articles);
        foreach ($articles as $key => $article) {
            $articles[$key]['idArticle'] = $data['inserted'][$key]['idArticle']['idArticle'];
            $articles[$key]['price'] += 0.01;
        }

        $updatedArticles = $this->api->stock->update($articles);

        $this->assertArrayHasKey('updatedArticles', $updatedArticles);
        $this->assertArrayHasKey('notUpdatedArticles', $updatedArticles);
        $this->assertCount(2, $updatedArticles['updatedArticles']);

        foreach ($articles as $key => $article) {
            $articles[$key]['idArticle'] = $updatedArticles['updatedArticles'][$key]['idArticle'];
        }
        $this->api->stock->delete($articles);
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

        $articleId = $data['inserted']['idArticle']['idArticle'];
        $article = [
            'idArticle' => $articleId,
            'amount' => 1,
        ];
        $data = $this->api->stock->increase($article);
        $this->assertEquals(2, $data['article']['count']);

        $data = $this->api->stock->decrease($article);
        $this->assertEquals(1, $data['article']['count']);

        $article = [
            'idArticle' => $articleId,
            'count' => 1,
        ];
        $this->api->stock->delete($article);
    }

    /** @test */
    // does not work in sandbox
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

        $article = [
            'idProduct' => self::VALID_PRODUCT_ID,
            'idLanguage' => 1,
            'comments' => 'Inserted through the API',
            'count' => 1,
            'price' => 1,
            'condition' => 'EX',
        ];

        $data = $this->api->stock->add($article);
        $newArticleId = $data['inserted']['idArticle']['idArticle'];

        $articles[] = [
            'idArticle' => $newArticleId,
            'count' => 1,
        ];

        $data = $this->api->stock->delete($articles);
        $this->assertArrayHasKey('deleted', $data);
        $this->assertEquals('true', $data['deleted']['success']);
        $this->assertEquals('1', $data['deleted']['count']);
        $this->assertEquals($newArticleId, $data['deleted']['idArticle']);
    }

    /** @test */
    public function deletesTwoArticles()
    {
        $articles = [
            [
                'idProduct' => self::VALID_PRODUCT_ID,
                'idLanguage' => 1,
                'comments' => 'Inserted through the API',
                'count' => 1,
                'price' => 0.02,
                'condition' => 'EX',
            ],
            [
                'idProduct' => self::VALID_PRODUCT_ID,
                'idLanguage' => 1,
                'comments' => 'Inserted through the API',
                'count' => 1,
                'price' => 0.02,
                'condition' => 'EX',
            ],
        ];

        $data = $this->api->stock->add($articles);
        foreach ($articles as $key => $article) {
            $articles[$key]['idArticle'] = $data['inserted'][$key]['idArticle']['idArticle'];
        }

        $data = $this->api->stock->delete($articles);

        $this->assertArrayHasKey('deleted', $data);
        $this->assertCount(2, $data['deleted']);

        $this->assertEquals('true', $data['deleted'][0]['success']);
        $this->assertEquals('1', $data['deleted'][0]['count']);
        $this->assertEquals($articles[0]['idArticle'], $data['deleted'][0]['idArticle']);

        $this->assertEquals('true', $data['deleted'][1]['success']);
        $this->assertEquals('1', $data['deleted'][1]['count']);
        $this->assertEquals($articles[1]['idArticle'], $data['deleted'][1]['idArticle']);
    }

    /** @test */
    // public function deletesAllArticles()
    // {
    //     $articles = [];

    //     $stocks = $this->api->stock->get();

    //     foreach ($stocks['article'] as $key => $stock) {
    //         $articles[] = [
    //             'idArticle' => $stock['idArticle'],
    //             'count' => $stock['count'],
    //         ];
    //     }

    //     $data = $this->api->stock->delete($articles);

    //     $stocks = $this->api->stock->get();
    //     $this->assertCount(0, $stocks['article']);
    // }


}