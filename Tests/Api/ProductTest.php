<?php

namespace Cardmonitor\Cardmarket\Tests\Api;

use Cardmonitor\Cardmarket\Product;
use GuzzleHttp\Client;

class ProductTest extends \Cardmonitor\Cardmarket\Tests\TestCase
{
    const VALID_PRODUCT_ID = 265535;

    /** @test */
    public function getsCsv()
    {
        $data = $this->api->product->csv();

        $filename = 'products.csv';
        $zippedFilename = $filename . '.gz';

        $handle = fopen($zippedFilename, 'wa+');
        fwrite( $handle, base64_decode( $data['productsfile'] ) );
        fclose( $handle );

        $this->assertFileExists($zippedFilename);

        shell_exec('gunzip ' . $filename);

        $this->assertFileExists($filename);

        unlink($filename);
        unlink($zippedFilename);
    }

    /**
     * @test
     */
    public function getsProduct()
    {
        $data = $this->api->product->get(self::VALID_PRODUCT_ID);
        $this->api->product->download(substr($data['product']['image'], 1), './test.jpg');
        $this->assertArrayHasKey('product', $data);
        $this->assertArrayHasKey('priceGuide', $data['product']);
        $this->assertEquals(self::VALID_PRODUCT_ID, $data['product']['idProduct']);
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
    }

}