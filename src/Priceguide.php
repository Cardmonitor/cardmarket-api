<?php

    namespace Cardmonitor\Cardmarket;

    class Priceguide extends AbstractApi
    {
        public function csv(int $gameId = 1)
        {
            return $this->_get('priceguide', [
                'idGame' => $gameId,
            ]);
        }
    }

?>