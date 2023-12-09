<?php
namespace Cardmonitor\Cardmarket;

class Api
{
    const URL_API = 'https://api.cardmarket.com';
    const URL_SANDBOX = 'https://sandbox.cardmarket.com';

    const VERSION = '2.0';

    public Access $access;
    public Account $account;
    public Expansion $expansion;
    public Games $games;
    public Messages $messages;
    public Order $order;
    public Priceguide $priceguide;
    public Product $product;
    public Stock $stock;
    public StockExport $stock_export;

    protected $client;

    protected $requestLimitMax = 0;
    protected $requestLimitCount = 0;

    public function __construct(array $access, array $parameters = [])
    {
        $access['url'] = $this->getUrl($access['url'] ?? '');

        $this->access = new Access($this, $access, $parameters);
        $this->account = new Account($this, $access, $parameters);
        $this->expansion = new Expansion($this, $access, $parameters);
        $this->games = new Games($this, $access, $parameters);
        $this->messages = new Messages($this, $access, $parameters);
        $this->order = new Order($this, $access, $parameters);
        $this->priceguide = new Priceguide($this, $access, $parameters);
        $this->product = new Product($this, $access, $parameters);
        $this->stock = new Stock($this, $access, $parameters);
        $this->stock_export = new StockExport($this, $access, $parameters);
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