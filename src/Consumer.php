<?php

namespace Webit\MessageBus;

interface Consumer
{
    /**
     * @param Message $message
     */
    public function consume(Message $message);
}