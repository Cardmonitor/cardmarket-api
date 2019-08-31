<?php

namespace Cardmonitor\Cardmarket;

use GuzzleHttp\Subscriber\Oauth\Oauth1 as GuzzleOauth1;

class Oauth1 extends GuzzleOauth1
{
    /**
     * Builds the Authorization header for a request
     *
     * @param array $params Associative array of authorization parameters.
     *
     * @return array
     */
    private function buildAuthorizationHeader(array $params)
    {
        $realm = $params['path'] ?? '';
        unset($params['path']);

        foreach ($params as $key => $value) {
            $params[$key] = $key . '="' . rawurlencode($value) . '"';
        }

        if (isset($this->config['realm'])) {
            array_unshift(
                $params,
                'realm="' . rawurlencode($this->config['realm'] . $realm) . '"'
            );
        }

        return ['Authorization', 'OAuth ' . implode(', ', $params)];
    }
}