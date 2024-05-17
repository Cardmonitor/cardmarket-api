<?php

    namespace Cardmonitor\Cardmarket;

    class User extends AbstractApi
    {
        public function create()
        {
            return $this->_post('exports/userOffers', []);
        }

        public function get(string $search)
        {
            return $this->_get('users/find', [
                'search' => $search
            ]);
        }

        public function findById(int $user_id)
        {
            return $this->_get('users/' . $user_id);
        }

        public function findByName(string $username)
        {
            return $this->_get('users/' . $username);
        }
    }

?>