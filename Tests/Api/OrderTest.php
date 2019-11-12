<?php

namespace Cardmonitor\Cardmarket\Tests\Api;

use Cardmonitor\Cardmarket\Order;

class OrderTest extends \Cardmonitor\Cardmarket\Tests\TestCase
{

    /** @test */
    public function findsAllBoughtOrders()
    {
        $data = $this->api->order->find(Order::ACTOR_BUYER, ORDER::STATE_PAID);
        var_dump($data);
        $this->assertArrayHasKey('order', $data);
    }

    /** @test */
    public function findsAllSoldPaidOrders()
    {
        $data = $this->api->order->find(Order::ACTOR_SELLER, ORDER::STATE_PAID);
        var_dump($data);
        $this->assertArrayHasKey('order', $data);
    }

    /** @test */
    public function findsAllSoldReceivedOrders()
    {
        $orders = [];
        $start = 1;
        do {
            $data = $this->api->order->find(Order::ACTOR_SELLER, ORDER::STATE_RECEIVED, $start);
            if (is_array($data)) {
                $orders += $data['order'];
                $start += 100;
            }
        }
        while (! is_null($data));

        var_dump(count($orders));
        // var_dump($orders);
        $this->assertArrayHasKey('order', $data);
    }

    /**
     * @test
     */
    public function marksOrderAsSend()
    {
        $data = $this->api->order->send(65327252);
        var_dump($data);
    }

    /** @test */
    public function getOneOrder()
    {
        $article = [
            'idProduct' => self::VALID_PRODUCT_ID,
            'idLanguage' => 1,
            'comments' => 'Inserted through the API',
            'count' => 1,
            'price' => 4,
            'condition' => 'EX',
        ];

        $data = $this->api->stock->add($article);

        $stocks = $this->api->stock->get();
        $stock = $stocks['article'][0];

        $data = $this->api->stock->article($stock['idArticle']);
        var_dump($data);
        $this->assertArrayHasKey('article', $data);
    }

}