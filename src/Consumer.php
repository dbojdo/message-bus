<?php

namespace Webit\MessageBus;

use Webit\MessageBus\Consumer\Exception\MessageConsumptionException;

interface Consumer
{
    /**
     * @param Message $message
     * @throws MessageConsumptionException
     */
    public function consume(Message $message);
}
