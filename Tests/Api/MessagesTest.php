<?php

namespace Cardmonitor\Cardmarket\Tests\Api;

class MessagesTest extends \Cardmonitor\Cardmarket\Tests\TestCase
{
    private int $userId = 0;
    private int $messageId = 0;

    /** @test */
    public function getsAllMessages()
    {
        $data = $this->api->messages->get();
        $this->assertArrayHasKey('thread', $data);

        if (count($data['thread']) > 0) {
            $this->userId = $data['thread'][0]['partner']['idUser'];
            $this->messageId = $data['thread'][0]['message']['idMessage'];
        }
    }

    /** @test */
    public function getsAllMessagesFromOneUser()
    {
        if ($this->userId === 0) {
            $this->markTestSkipped('No user id found.');
        }

        $data = $this->api->messages->get($this->userId);
        $this->assertArrayHasKey('thread', $data);
    }

    /** @test */
    public function getsOneMessageFromOneUser()
    {
        if ($this->userId === 0 || $this->messageId === 0) {
            $this->markTestSkipped('No user id or message id found.');
        }

        $data = $this->api->messages->get($this->userId, $this->messageId);

        $this->assertArrayHasKey('partner', $data);
        $this->assertArrayHasKey('message', $data);
        $this->assertCount(1, $data['message']);
    }

    /** @test */
    public function findsUnreadMessages()
    {
        $data = $this->api->messages->unread();

        $this->markTestSkipped('must be revisited.');
    }

    /** @test */
    public function findsReadMessages()
    {
        $this->markTestSkipped('Needs the startDate parameter.');

        $data = $this->api->messages->read();

    }

    /** @test */
    public function findsMessagesBetweenOneDateAndNow()
    {
        $this->markTestSkipped('must be revisited.');
    }

    /** @test */
    public function findsMessagesBetweenTwoDates()
    {
        $this->markTestSkipped('must be revisited.');
    }

    /** @test */
    public function sendsMessage()
    {
        $text = 'Test Message';

        $data = $this->api->messages->send(1066387, $text);

        $this->assertArrayHasKey('partner', $data);
        $this->assertArrayHasKey('message', $data);
        $this->assertEquals('true', $data['message']['isSending']);
        $this->assertEquals($text, $data['message']['text']);
    }

    /** @test */
    public function deletesMessage()
    {
        $this->markTestSkipped('must be revisited.');
    }

    /** @test */
    public function deletesAllMessageFromOneUser()
    {
        $this->markTestSkipped('must be revisited.');
    }


}