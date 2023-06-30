<?php

namespace Dmn\Txtbox;

interface Txtbox
{
    /**
     * Send
     *
     * @param string $mobileNumber
     * @param string $message
     *
     * @return void
     */
    public function send(
        string $mobileNumber,
        string $message,
    ): void;
}
