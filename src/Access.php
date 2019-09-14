<?php

    namespace Cardmonitor\Cardmarket;

use Cardmonitor\Cardmarket\Api;

    class Access extends AbstractApi
    {
        public function link(string $language = 'de')
        {
            return $this->access['url'] . '/ws/v' . Api::VERSION . '/authenticate/' . $this->access['app_token'] . '/' . $language;
        }

        public function token(string $request_token)
        {
            return $this->_post('access', [
                'app_key' => $this->access['app_token'],
                'request_token' => $request_token,
            ]);
        }
    }

?>