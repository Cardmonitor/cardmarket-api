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

        protected $requestLimitMax = 0;
        protected $requestLimitCount = 0;

        public function __construct(array $access)
        {
            $access['url'] = $this->getUrl($access['url'] ?? '');

            $this->account = new Account($this, $access);
            $this->expansion = new Expansion($this, $access);
            $this->messages = new Messages($this, $access);
            $this->product = new Product($this, $access);
            $this->priceguide = new Priceguide($this, $access);
            $this->stock = new Stock($this, $access);
            $this->order = new Order($this, $access);
        }

        public function setRequestLimitCount(int $limit) : void
        {
            $this->requestLimitCount = $limit;
        }

        public function setRequestLimitMax(int $limit) : void
        {
            $this->requestLimitMax = $limit;
        }

        public function getRequestLimitCount() : int
        {
            return $this->requestLimitCount;
        }

        public function getRequestLimitMax() : int
        {
            return $this->requestLimitMax;
        }

        private function getUrl(string $url) : string
        {
            return $url ?: self::URL_API;
        }
    }