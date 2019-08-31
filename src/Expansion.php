<?php

    namespace Cardmonitor\Cardmarket;

    class Expansion extends AbstractApi
    {
        public function find(int $gameId = 1)
        {
            return $this->_get('games/' . $gameId . '/expansions');
        }

        // max 100 entries
        public function singles(int $expansionId)
        {
            return $this->_get('expansions/' . $expansionId . '/singles');
        }
    }

?>