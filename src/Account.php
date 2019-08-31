<?php

    namespace Cardmonitor\Cardmarket;

    class Account extends AbstractApi
    {

        public function get()
        {
            return $this->_get('account');
        }

        // TODO: Test
        public function changeVacationStatus(bool $onVacation = true, bool $cancelOrders = false, bool $relistItems = false)
        {
            return $this->_put('account/vacation', [
                'cancelOrders'  => $cancelOrders,
                'onVacation'    => $onVacation,
                'relistItems'   => ($cancelOrders ? $relistItems : false),
            ]);
        }

        // TODO: Test
        /**
         *      1: English
         *      2: French
         *      3: German
         *      4: Spanish
         *      5: Italian
         */
        public function changeDisplayLanguage(int $idDisplayLanguage)
        {
            return $this->_put('account/language', [
                'idDisplayLanguage'  => $idDisplayLanguage,
            ]);
        }

    }
?>