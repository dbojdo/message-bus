<?php

namespace Webit\MessageBus;

use Webit\MessageBus\Publisher\Exception\MessagePublicationException;

interface Publisher
{
    /**
     * @param Message $message
     * @throws MessagePublicationException
     */
    public function publish(Message $message);
}