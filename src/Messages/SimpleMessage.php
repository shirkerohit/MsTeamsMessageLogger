<?php

namespace Rohits\Src\Messages;

class SimpleMessage implements MessageContract
{
    protected $title = null;
    protected $message = null;

    /**
     * Get the value of title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of message
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set the value of message
     *
     * @return  self
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    public function getPayload()
    {
        return [
            "title" => $this->getTitle(),
            "text" => $this->getMessage(),
        ];
    }
}
