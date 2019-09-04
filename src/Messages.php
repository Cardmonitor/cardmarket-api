<?php

    namespace Cardmonitor\Cardmarket;

    class Messages extends AbstractApi
    {

        public function get(int $userId = 0, int $messageId = 0)
        {
            return $this->_get('account/messages' . ($userId > 0 ? '/' . $userId . ($messageId > 0 ? '/' . $messageId : '') : ''));
        }

        public function unread()
        {
            return $this->find([ 'unread' => true ]);
        }

        public function read()
        {
            return $this->find([ 'unread' => 'false' ]);
        }

        public function find(array $parameters)
        {
            return $this->_get('account/messages/find', $parameters);
        }

        public function delete(int $userId, int $messageId = 0)
        {
            return $this->_delete('account/messages/' . $userId . ($messageId ? '/' . $messageId : ''));
        }

        public function send(int $userId, string $message)
        {
            return $this->_post('account/messages/' . $userId, [ 'message' => $message ]);
        }

    }

?>