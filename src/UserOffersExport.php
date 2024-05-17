<?php

    namespace Cardmonitor\Cardmarket;

    class UserOffersExport extends AbstractApi
    {
        public function create(int $user_id)
        {
            return $this->_post('exports/userOffers/' . $user_id, []);
        }

        public function get()
        {
            return $this->_get('exports/userOffers');
        }

        public function find(int $user_id)
        {
            return $this->_get('exports/userOffers/' . $user_id);
        }
    }

?>