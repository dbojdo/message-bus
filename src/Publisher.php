<?php

namespace Webit\MessageBus;

interface Publisher
{
    /**
     * @param Message $message
     */
    public function publish(Message $message);
}