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
        var_dump($orders);
        $this->assertArrayHasKey('order', $data);
    }

    /** @test */
    public function findsAllSoldCancelledOrders()
    {
        $data = $this->api->order->find(Order::ACTOR_SELLER, ORDER::STATE_CANCELLED);
        var_dump($data);
        $this->assertArrayHasKey('order', $data);
    }

    /**
     * @test
     */
    public function marksOrderAsSend()
    {
        $data = $this->api->order->send(65105546);
        var_dump($data);
    }

    /** @test */
    public function getOneOrder()
    {
        $orderId = 65407374;
        $data = $this->api->order->get($orderId);
        var_dump(json_encode($data));
        var_dump($data['order']['article'][0]);
        $this->assertArrayHasKey('order', $data);
        $this->assertEquals($orderId, $data['order']['idOrder']);
    }

    /**
     * @test
     */
    public function it_sets_a_trackingnumber_for_an_order()
    {
        $orderId = 65007180;
        $data = $this->api->order->setTrackingNumber($orderId, '123456789');
        var_dump($data);
    }

}