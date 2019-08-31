<?php

namespace Cardmonitor\Cardmarket\Tests\Api;

class MessagesTest extends \Cardmonitor\Cardmarket\Tests\TestCase
{
    /** @test */
    public function getsAllMessages()
    {
        $data = $this->api->messages->get();

        $this->assertArrayHasKey('thread', $data);
    }

    /** @test */
    public function getsAllMessagesFromOneUser()
    {
        $data = $this->api->messages->get(1880393);

        $this->assertArrayHasKey('partner', $data);
        $this->assertArrayHasKey('message', $data);
    }

    /** @test */
    public function getsOneMessageFromOneUser()
    {
        $data = $this->api->messages->get(1880393, 14189911);

        $this->assertArrayHasKey('partner', $data);
        $this->assertArrayHasKey('message', $data);
        $this->assertCount(1, $data['message']);
    }

    /** @test */
    public function findsUnreadMessages()
    {
        $data = $this->api->messages->unread();

        var_dump($data);

        $this->markTestSkipped('must be revisited.');
    }

    /** @test */
    public function findsReadMessages()
    {
        $data = $this->api->messages->read();

        var_dump($data);

        $this->markTestSkipped('must be revisited.');
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

        $data = $this->api->messages->get(1066387);
        $this->assertEquals($text, $data['message'][0]['text']);
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