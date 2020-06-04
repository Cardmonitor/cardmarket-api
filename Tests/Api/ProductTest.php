<?php

namespace Cardmonitor\Cardmarket\Tests\Api;

use Cardmonitor\Cardmarket\Product;
use GuzzleHttp\Client;

class ProductTest extends \Cardmonitor\Cardmarket\Tests\TestCase
{
    const VALID_PRODUCT_ID = 265882;

    /** @test */
    public function getsCsv()
    {
        $this->markTestSkipped('No data from Cardmarket');

        $gameId = 6;
        $data = $this->api->product->csv($gameId);

        $filename = 'products-' . $gameId . '.csv';
        $zippedFilename = $filename . '.gz';

        $this->assertFileNotExists($zippedFilename);
        $this->assertFileNotExists($filename);

        $handle = fopen($zippedFilename, 'wa+');
        fwrite( $handle, base64_decode( $data['productsfile'] ) );
        fclose( $handle );

        $this->assertFileExists($zippedFilename);

        shell_exec('gunzip ' . $filename);

        $this->assertFileExists($filename);

        unlink($filename);
    }

    /**
     * @test
     */
    public function getsProduct()
    {
        $product = json_decode(file_get_contents('Tests/responses/product/get.json'), true);
        $productId = $product['product']['idProduct'];

        $data = $this->api->product->get($productId);
        var_dump($data);

        $this->assertEquals($productId, $data['product']['idProduct']);
        $this->assertArrayHasKey('product', $data);
        foreach ($product['product'] as $key => $value) {
            $this->assertArrayHasKey($key, $data['product']);
        }
    }

    /**
     * @test
     */
    public function it_can_download_the_image_of_a_product()
    {
        $product = json_decode(file_get_contents('Tests/responses/product/get.json'), true);
        $filename = './test.jpg';

        $this->assertFileNotExists($filename);

        $this->api->product->download(substr($product['product']['image'], 1), $filename);

        $this->assertFileExists($filename);
        unlink($filename);
    }

    /**
     * @test
     */
    public function findsProducts()
    {
        $data = $this->api->product->find('Springleaf Drum', [
            'exact' => 'true',
            'idGame' => 1,
            'idLanguage' => 1,
        ]);
        $this->assertArrayHasKey('product', $data);
        $this->assertCount(2, $data['product']);

        var_dump($data);
    }

}