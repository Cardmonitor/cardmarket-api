<?php

    namespace Cardmonitor\Cardmarket;

    class StockExport extends AbstractApi
    {
        public function create(int $game_id = 0)
        {
            return $this->_post('exports/stock' . ($game_id ? '?idGame=' . $game_id : ''), []);
        }

        public function get()
        {
            return $this->_get('exports/stock');
        }

        public function find(int $export_id)
        {
            return $this->_get('exports/stock/' . $export_id);
        }
    }

?>