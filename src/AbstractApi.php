<?php

namespace Cardmonitor\Cardmarket;

use Cardmonitor\Cardmarket\Api;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Subscriber\Oauth\Oauth1;
use Spatie\ArrayToXml\ArrayToXml;

abstract class AbstractApi
{
    protected $access;
    protected $api;
    protected $basePath = 'ws/v' . Api::VERSION . '/';
    protected $debug = false;

    protected $tries = 0;

    /**
     * Parameters to be added for guzzle.
     *
     * @var array
     */
    protected $parameters = [];

    public function __construct(Api $api, array $access, array $parameters = [])
    {
        $this->access = $access;
        $this->api = $api;
        $this->debug = $access['debug'] ?? false;
        $this->parameters = $parameters;
    }

    protected function getClient(string $path) {

        $stack = HandlerStack::create();

        $middleware = new Oauth1([
            'consumer_key'    => $this->access['app_token'],
            'consumer_secret' => $this->access['app_secret'],
            'token'           => $this->access['access_token'] ?? '',
            'token_secret'    => $this->access['access_token_secret'] ?? '',
            'realm'           => $this->access['url'] . '/' . $this->basePath . $path,
        ]);

        $stack->push($middleware);

        $baseParameters = [
            'auth'      => 'oauth',
            'base_uri'  => $this->access['url'],
            'handler'   => $stack,
            'timeout'   => 10.0,
        ];
        $parameters = array_merge($baseParameters, $this->parameters);

        return new Client($parameters);
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
        $this->setRequestLimit($response);

        return $this->xmlToArray($response->getBody());
    }

    protected function _get(string $path, array $parameters = [])
    {
        return $this->request('GET', 'output.json/' . $path, $parameters);
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
        $this->setRequestLimit($response);

        return $this->xmlToArray($response->getBody());
    }

    protected function _put(string $path, array $parameters, array $xmlParameters = [])
    {
        $xmlParametersCount = count($xmlParameters);

        $request = new Request(
            'PUT',
            $this->basePath . $path . (count($parameters) > 0 ? '?' . http_build_query($parameters) : ''),
            ['Content-Type' => 'text/xml; charset=UTF8'],
            $xmlParametersCount ? ArrayToXml::convert($xmlParameters, 'request') : null,
        );
        $response = $this->getClient($path)->send($request, [
            'debug' => $this->debug
        ]);

        if ($this->debug) {
            if ($xmlParametersCount) {
                echo 'Request Body';
                echo ArrayToXml::convert($xmlParameters, 'request');
            }

            echo $response->getBody();
        }

        $this->setRequestLimit($response);

        return $this->xmlToArray($response->getBody());
    }

    protected function request(string $method, string $path = '', array $parameters = [])
    {
        try {
            $response = $this->getClient($path)->$method($this->basePath . $path, [ 'query' => $parameters, 'debug' => $this->debug ]);
        }
        catch (ConnectException $e) {
            $this->tries++;

            if ($this->tries <= 3) {
                sleep(1);
                $response = $this->getClient($path)->$method($this->basePath . $path, [ 'query' => $parameters, 'debug' => $this->debug ]);
            }
            else {
                throw $e;
            }

        }

        if ($this->debug) {
            echo $response->getBody();
        }

        $this->setRequestLimit($response);

        return json_decode($response->getBody(), true);

    }

    protected function setRequestLimit(Response $response) : void
    {
        $headers = $response->getHeaders();
        if (array_key_exists('X-Request-Limit-Max', $headers)) {
            $this->api->setRequestLimitCount($headers['X-Request-Limit-Count'][0]);
            $this->api->setRequestLimitMax($headers['X-Request-Limit-Max'][0]);
        }
    }

    protected function xmlToArray(string $xmlstring) : array
    {
        $xml = simplexml_load_string($xmlstring, "SimpleXMLElement", LIBXML_NOCDATA);
        $json = json_encode($xml);
        $array = json_decode($json, true);
        array_walk_recursive($array, function (&$item, $key) {
            if ($item == 'true') {
                $item = true;
            }
            elseif ($item == 'false') {
                $item = false;
            }
        });

        return $this->emptyArrayToString($array);
    }

    protected function emptyArrayToString($haystack)
    {
        foreach ($haystack as $key => $value) {
            if (is_array($value)) {
                $haystack[$key] = $this->emptyArrayToString($haystack[$key]);
            }

            if (is_array($haystack[$key]) && empty($haystack[$key])) {
                $haystack[$key] = '';
            }
        }

        return $haystack;
    }

}

?>