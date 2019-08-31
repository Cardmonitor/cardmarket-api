<?php
    namespace Cardmonitor\Cardmarket;

    use GuzzleHttp\Client;
    use GuzzleHttp\HandlerStack;
    use GuzzleHttp\Subscriber\Oauth\Oauth1;

    class Api
    {
        const URL_API = 'https://api.cardmarket.com';
        const URL_SANDBOX = 'https://sandbox.cardmarket.com';

        protected $client;

        public function __construct(array $access)
        {
            $access['url'] = $this->getUrl($access['url'] ?? '');

            $this->account = new Account($access);
            $this->expansion = new Expansion($access);
            $this->messages = new Messages($access);
            $this->product = new Product($access);
            $this->stock = new Stock($access);
            $this->order = new Order($access);
        }

        private function getUrl(string $url) : string
        {
            return $url ?: self::URL_API;
        }
    }