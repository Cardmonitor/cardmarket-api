<?php

    namespace Cardmonitor\Cardmarket;

    class StockArticle extends AbstractApi
    {
        public function get(int $articleId)
        {
            return $this->_get('stock/article/' . $articleId);
        }

        public function find(string $name, int $gameId = 1)
        {
            return $this->_get('stock/articles/' . rawurlencode($name) . '/' . $gameId);rawurlencode
        }

        public function increase(int $articleId, int $amount = 1)
        {
            return $this->changeAmount('increase', $articleId, $amount);
        }

        public function decrease(int $articleId, int $amount = 1)
        {
            return $this->changeAmount('decrease', $articleId, $amount);
        }

        protected function changeAmount(string $path, int $articleId, int $amount)
        {
            return $this->_put('stock/' . $path, [
                'idArticle' => $articleId,
                'amount'    => $amount
            ]);
        }
    }

?>