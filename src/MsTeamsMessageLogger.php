<?php

namespace Rohits\Src;

use GuzzleHttp\Client;
use Rohits\Src\Messages\MessageContract;
use Exception;

class MsTeamsMessageLogger
{
    /**
     * Payload object
     *
     * @var MessageContract
     */
    protected $messagePayload;

    /**
     * Configuration
     *
     * @var array
     */
    protected $config = null;

    /**
     * Url
     *
     * @var String
     */
    protected $url = null;

    public function __construct()
    {
        $this->setup();
    }

    /**
     * Setup and load config.
     *
     * @return void
     */
    protected function setup()
    {
        $config = include("./config.php");

        $this->setConfig($config);

        return $this;
    }

    /**
     * Set the value of config
     *
     * @return  self
     */
    public function setConfig($config)
    {
        $this->config = $config;

        $this->validateConfig();

        $this->loadConfig();

        return $this;
    }

    /**
     * Set value to config params.
     *
     * @return self
     */
    public function loadConfig()
    {
        $this->url = $this->config["url"];

        return $this;
    }

    /**
     * Validate configuration.
     *
     * @return self
     */
    public function validateConfig()
    {
        if ((!is_array($this->config)) || (!array_key_exists("url", $this->config))) {
            throw new Exception("Invalid configuration.");
        }
        return $this;
    }

    /**
     * Log the response to Teams channel.
     *
     * @param MessageContract $messagePayload
     * @return GuzzleHttp\Psr7\Response
     */
    public function log(MessageContract $messagePayload)
    {
        $this->messagePayload  = $messagePayload;
        return $this->sendMessage();
    }

    /**
     * Call the Gateway to send message.
     *
     * @return GuzzleHttp\Psr7\Response
     */
    protected function sendMessage()
    {
        $client = new Client();

        $response = $client->request('POST', $this->url, [
            'json' => $this->messagePayload->getPayload()
        ]);

        return $response;
    }
}
