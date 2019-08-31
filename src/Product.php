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
    }

?>