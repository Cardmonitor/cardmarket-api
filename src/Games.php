<?php

namespace Cardmonitor\Cardmarket;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Subscriber\Oauth\Oauth1;

class Games extends AbstractApi
{
    public function get()
    {
        return $this->_get('games');
    }

}

?>