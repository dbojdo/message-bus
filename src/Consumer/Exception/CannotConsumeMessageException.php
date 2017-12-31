<?php

namespace Webit\MessageBus\Consumer\Exception;

use Webit\MessageBus\Message;

class CannotConsumeMessageException extends AbstractMessageConsumptionException
{
    protected static function createExceptionMessage(Message $message): string
    {
        return sprintf('Error during consumption of the message of type "%s".', $message->type());
    }
}