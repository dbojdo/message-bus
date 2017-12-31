<?php

namespace Webit\MessageBus\Consumer\Exception;

use Webit\MessageBus\Message;

class UnsupportedMessageTypeException extends AbstractMessageConsumptionException
{
    protected static function createExceptionMessage(Message $message): string
    {
        return sprintf('Message of type "%s" is not supported by this consumer.', $message->type());
    }
}