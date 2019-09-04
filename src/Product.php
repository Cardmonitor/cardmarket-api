<?php

    namespace Cardmonitor\Cardmarket;

    class Product extends AbstractApi
    {
        public function csv(int $gameId = 1, bool $isSealed = false, int $languageId = 1)
        {
            return $this->_get('productlist?idGame=' . $gameId . '&isSealed=' . ($isSealed ? 'true' : 'false') . '&idLanguage=' . $languageId);
        }

        // max 100 entries
        public function get(int $productId)
        {
            return $this->_get('products/' . $productId);
        }

        /**
         * @var $parameters:
         *          string search
         *          string exact (true|false)
         *          int idGame
         *          int idLanguage
         *          int start
         *          int maxResults
         */
        public function find(string $search, array $parameters = [])
        {
            $parameters['search'] = $search;

            return $this->_get('products/find', $parameters);
        }
    }

?>