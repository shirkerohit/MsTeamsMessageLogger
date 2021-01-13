<?php

namespace Tests;

use Exception;
use PHPUnit\Framework\TestCase;
use Rohits\Src\Messages\SimpleMessage;
use Rohits\Src\MsTeamsMessageLogger;
use Throwable;

class TeamsMessageTest extends TestCase
{
    protected $reporter = null;

    protected $message = null;

    public function setUp(): void
    {
        $this->message = new SimpleMessage();
        $this->message->setTitle("Title");
        $this->message->setMessage("Message");
    }

    public function test_it_load_valid_config(): void
    {
        $this->expectException(Exception::class);
        $obj = new MsTeamsMessageLogger();
        $obj->setConfig([]);
        $obj->log($this->message);
    }

    public function test_it_fails_with_invalid_url(): void
    {
        $this->expectException(Throwable::class);

        $obj = new MsTeamsMessageLogger();

        $obj->setConfig([
            "url" => "https://invalidurl.test",
        ]);

        $obj->log($this->message);
    }

    public function test_it_sends_message(): void
    {
        $obj  = $this->createPartialMock(MsTeamsMessageLogger::class, ['log']);

        $obj->expects($this->any())->method("log")->willReturn(
            (new \GuzzleHttp\Psr7\Response(200, []))
        );

        $obj->setConfig([
            "url" => "https://some.url.test",
        ]);

        $response = $obj->log($this->message);

        $statusCode = $response->getStatusCode();

        $this->assertEquals(200, $statusCode);
    }
}
