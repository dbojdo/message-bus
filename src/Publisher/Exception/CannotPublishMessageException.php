<?php

namespace Webit\MessageBus\Publisher\Exception;

use Webit\MessageBus\Message;

class CannotPublishMessageException extends AbstractMessagePublicationException
{
    protected static function createExceptionMessage(Message $message): string
    {
        return sprintf('Error during publication of the message of type "%s".', $message->type());
    }
}