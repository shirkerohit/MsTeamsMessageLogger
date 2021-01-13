<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Rohits\Src\Messages\SimpleMessage;

class SimpleMessageTest extends TestCase
{
    protected $message = null;

    public function setUp(): void
    {
        $this->message = new SimpleMessage();
        $this->message->setTitle("Title");
        $this->message->setMessage("Message");
    }

    public function test_simple_message(): void
    {
        $this->assertEquals($this->message->getTitle(), "Title");
        $this->assertEquals($this->message->getMessage(), "Message");
    }


    public function test_simple_response_payload(): void
    {
        $this->assertArrayHasKey("title", $this->message->getPayload());
        $this->assertArrayHasKey("text", $this->message->getPayload());
    }
}
