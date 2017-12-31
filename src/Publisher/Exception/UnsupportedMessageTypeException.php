<?php

namespace Webit\MessageBus\Publisher\Exception;

use Webit\MessageBus\Message;

class UnsupportedMessageTypeException extends AbstractMessagePublicationException
{
    protected static function createExceptionMessage(Message $message): string
    {
        return sprintf('Message of type "%s" is not supported by this publisher.', $message->type());
    }
}