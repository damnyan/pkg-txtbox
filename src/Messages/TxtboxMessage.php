<?php

namespace Dmn\Txtbox\Messages;

class TxtboxMessage
{
    protected $mobileNumber;

    protected $message;

    /**
     * Get the value of mobileNumber
     *
     * @return string
     */
    public function getMobileNumber(): string
    {
        return $this->mobileNumber;
    }

    /**
     * Set the value of mobileNumber
     *
     * @param string $mobileNumber
     *
     * @return self
     */
    public function setMobileNumber(string $mobileNumber): self
    {
        $this->mobileNumber = $mobileNumber;

        return $this;
    }

    /**
     * Get the value of message
     *
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * Set the value of message
     *
     * @param string $message
     *
     * @return self
     */
    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }
}
