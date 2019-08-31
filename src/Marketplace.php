<?php

    namespace Cardmonitor\Cardmarket;

    class Marketplace extends AbstractApi
    {
        public function games()
        {
            return $this->_get('games');
        }
    }

?>