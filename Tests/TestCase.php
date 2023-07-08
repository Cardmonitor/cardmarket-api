<?php

namespace Cardmonitor\Cardmarket\Tests;

use Cardmonitor\Cardmarket\Api;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;

class TestCase extends PHPUnitTestCase
{
    protected Api $api;
    protected array $access_data = [];

    protected function setUp(): void
    {
        $this->access_data = [
            'app_token' => $_ENV['app_token'],
            'app_secret' => $_ENV['app_secret'],
            'access_token' => $_ENV['access_token'],
            'access_token_secret' => $_ENV['access_token_secret'],
            'url' => Api::URL_API,
        ];
        $this->api = new Api($this->access_data);
    }
}