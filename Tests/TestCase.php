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

        $this->api = new Api($accessSandbox + ['url' => Api::URL_SANDBOX]);
    }
}