<?php

namespace Cardmonitor\Cardmarket\Tests;

use Cardmonitor\Cardmarket\Api;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;

class TestCase extends PHPUnitTestCase
{
    protected $api;

    protected function setUp()
    {
        require_once ('access.php');

        $this->api = new Api($accessSandboxTaces2, Api::URL_SANDBOX);
    }
}