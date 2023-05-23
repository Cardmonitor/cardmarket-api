<?php

    namespace Cardmonitor\Cardmarket;

    class Stock extends AbstractApi
    {
        public function add(array $articles)
        {
            $parameters = [
                'article' => $articles,
            ];

            return $this->_post('stock', $parameters);
        }

        public function article(int $articleId)
        {
            return $this->_get('stock/article/' . $articleId);
        }

        public function csv(int $gameId = 1, bool $isSealed = false, int $languageId = 1)
        {
            return $this->_get('stock/file', [
                'idGame' => $gameId,
                'isSealed' => ($isSealed ? 'true' : 'false'),
                'idLanguage' => $languageId,
            ]);
        }

        public function delete(array $articles)
        {
            $parameters = [
                'article' => $articles,
            ];

            return $this->_delete('stock', $parameters);
        }

        public function find(string $name, int $gameId = 1)
        {
            return $this->_get('stock/articles/' . $name . '/' . $gameId);
        }

        // max 100 entries
        public function get(int $start = 0)
        {
            return $this->_get('stock' . ($start ? '/' . $start : ''));
        }

        public function update(array $articles)
        {
            $xmlParameters = [
                'article' => $articles,
            ];

            return $this->_put('stock', [], $xmlParameters);
        }

        public function increase(array $articles)
        {
            $xmlParameters = [
                'article' => $articles,
            ];

            return $this->_put('stock/increase', [], $xmlParameters);
        }

        public function decrease(array $articles)
        {
            $xmlParameters = [
                'article' => $articles,
            ];

            return $this->_put('stock/decrease', [], $xmlParameters);
        }

        public function shoppingcartArticles()
        {
            return $this->_get('stock/shoppingcart-articles');
        }
    }

?>