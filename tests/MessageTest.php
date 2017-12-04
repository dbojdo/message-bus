<?php

namespace Webit\MessageBus;

class MessageTest extends AbstractTestCase
{
    /**
     * @test
     */
    public function itHasTypeAndContent()
    {
        $message = new Message($type = $this->randomString(), $content = $this->randomString());

        $this->assertEquals($type, $message->type());
        $this->assertEquals($content, $message->content());
    }

    /**
     * @test
     */
    public function itCastsToStringWithContent()
    {
        $message = $this->randomMessage();
        $this->assertEquals($message->content(), (string)$message);
    }
}
