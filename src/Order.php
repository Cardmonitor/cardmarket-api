<?php

    namespace Cardmonitor\Cardmarket;

    class Order extends AbstractApi
    {

        const ACTOR_SELLER = 'seller';
        const ACTOR_BUYER = 'buyer';

        const STATE_BOUGHT = 'bought';
        const STATE_PAID = 'paid';
        const STATE_SENT = 'sent';
        const STATE_RECEIVED = 'received';
        const STATE_LOST = 'lost';
        const STATE_CANCELLED = 'cancelled';

        public function get(int $orderId)
        {
            return $this->_get('order/' . $orderId);
        }

        public function find(string $actor = 'seller', string $state = 'bought', int $start = 0)
        {
            return $this->_get('orders/' . $actor . '/' . $state . ($start ? '/' . $start : ''));
        }

        public function send(int $orderId)
        {
            return $thid->_put('order/' . $orderId, [], [
                'action' => 'send'
            ]);
        }

        public function requestCancellation(int $orderId, string $reason, bool $relistItems = false)
        {
            return $thid->_put('order/' . $orderId, [], [
                'action' => 'requestCancellation',
                'reason' => $reason,
                'relistItems' => $relistItems ? 'true' : 'false',
            ]);
        }

        public function setTrackingNumber(int $orderId, string $trackingNumber)
        {
            return $thid->_put('order/' . $orderId . '/tracking', [], [
                'trackingNumber' => $trackingNumber
            ]);
        }

        public function evaluate(int $orderId, array $evaluation)
        {
            return $thid->_put('order/' . $orderId . '/evaluation', [], $evaluation);
        }

    }

?>