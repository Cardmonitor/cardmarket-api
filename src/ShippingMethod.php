<?php

    namespace Cardmonitor\Cardmarket;

    class ShippingMethod extends AbstractApi
    {

        public function get(int $reservationId)
        {
            return $this->_get('shoppingcart/shippingmethod/' . $reservationId);
        }

        public function update(int $reservationId, int $shippingMethodId)
        {

        }
    }

?>