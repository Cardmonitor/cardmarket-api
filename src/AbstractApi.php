<?php

namespace Cardmonitor\Cardmarket;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Subscriber\Oauth\Oauth1;
use Spatie\ArrayToXml\ArrayToXml;

abstract class AbstractApi
{
    protected $access;
    protected $basePath = 'ws/v2.0/';
    protected $debug = false;

    public function __construct(array $access)
    {
        $this->access = $access;

    }

    protected function getClient(string $path) {

        $stack = HandlerStack::create();

        $middleware = new Oauth1([
            'consumer_key'    => $this->access['app_token'],
            'consumer_secret' => $this->access['app_secret'],
            'token'           => $this->access['access_token'],
            'token_secret'    => $this->access['access_token_secret'],
            'realm'           => $this->access['url'] . '/' . $this->basePath . $path,
        ]);

        $stack->push($middleware);

        return new Client([
            'auth'      => 'oauth',
            'base_uri'  => $this->access['url'],
            'handler'   => $stack,
            'timeout'   => 2.0,
        ]);
    }

    protected function _delete(string $path, array $parameters = [])
    {
        $xml = ArrayToXml::convert($parameters, 'request');

        $request = new Request(
            'DELETE',
            $this->basePath . $path,
            ['Content-Type' => 'text/xml; charset=UTF8'],
            $xml
        );
        $response = $this->getClient($path)->send($request);

        return json_decode($response->getBody(), true);
    }

    protected function _get(string $path, array $parameters = [])
    {
        return $this->request('GET', 'output.json/' . $path . (count($parameters) > 0 ? '?' . http_build_query($parameters) : ''));
    }

    protected function _post(string $path, array $parameters)
    {
        $request = new Request(
            'POST',
            $this->basePath . $path,
            ['Content-Type' => 'text/xml; charset=UTF8'],
            ArrayToXml::convert($parameters, 'request')
        );
        $response = $this->getClient($path)->send($request);

        return json_decode($response->getBody(), true);
    }

    protected function _put(string $path, array $parameters, array $xmlParameters = [])
    {
        $request = new Request(
            'PUT',
            $this->basePath . $path . (count($parameters) > 0 ? '?' . http_build_query($parameters) : ''),
            ['Content-Type' => 'text/xml; charset=UTF8'],
            count($xmlParameters) ? ArrayToXml::convert($xmlParameters, 'request') : null,
        );
        $response = $this->getClient($path)->send($request);

        return json_decode($response->getBody(), true);
    }

    protected function request(string $method, string $path = '', array $parameters = [])
    {

        $response = $this->getClient($path)->$method($this->basePath . $path, [ 'form_params' => $parameters, 'debug' => $this->debug ]);

        return json_decode($response->getBody(), true);

    }

}

?>