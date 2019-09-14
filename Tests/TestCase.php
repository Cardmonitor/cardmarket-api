<?php

namespace Cardmonitor\Cardmarket\Tests;

use Cardmonitor\Cardmarket\Api;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;

class TestCase extends PHPUnitTestCase
{
    protected $api;

    protected function setUp()
    {
        require('access.php');

        $this->accessData = $access3rdParty + ['url' => Api::URL_SANDBOX];
        $this->api = new Api($this->accessData);
    }
}