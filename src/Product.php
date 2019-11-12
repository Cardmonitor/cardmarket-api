<?php

    namespace Cardmonitor\Cardmarket;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Subscriber\Oauth\Oauth1;

    class Product extends AbstractApi
    {
        public function csv(int $gameId = 1, bool $isSealed = false, int $languageId = 1)
        {
            return $this->_get('productlist?idGame=' . $gameId . '&isSealed=' . ($isSealed ? 'true' : 'false') . '&idLanguage=' . $languageId);
        }

        // max 100 entries
        public function get(int $productId)
        {
            return $this->_get('products/' . $productId);
        }

        /**
         * @var $parameters:
         *          string search
         *          string exact (true|false)
         *          int idGame
         *          int idLanguage
         *          int start
         *          int maxResults
         */
        public function find(string $search, array $parameters = [])
        {
            $parameters['search'] = $search;

            return $this->_get('products/find', $parameters);
        }

        public function download(string $path, string $filename)
        {
            $client = new Client([
                'base_uri'  => 'https://static.cardmarket.com',
                'timeout'   => 5.0,
            ]);

            $resource = fopen($filename, 'w');

            $response = $client->request('GET', $path, [
                'headers' => [
                    'Cache-Control' => 'no-cache',
                    'Content-Type' => 'image/jpeg',
                ],
                'sink' => $resource,
            ]);
        }
    }

?>