<?php

namespace Cardmonitor\Cardmarket\Tests\Api;

use Cardmonitor\Cardmarket\Product;

class ProductTest extends \Cardmonitor\Cardmarket\Tests\TestCase
{

    /** @test */
    public function getsCsv()
    {
        $data = $this->api->priceguide->csv();

        $filename = 'priceguide.csv';
        $zippedFilename = $filename . '.gz';

        $handle = fopen($zippedFilename, 'wa+');
        fwrite( $handle, base64_decode( $data['priceguidefile'] ) );
        fclose( $handle );

        $this->assertFileExists($zippedFilename);

        shell_exec('gunzip ' . $filename);

        $this->assertFileExists($filename);

        unlink($filename);
        unlink($zippedFilename);
    }

}