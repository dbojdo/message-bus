<?php

namespace Webit\MessageBus\Publisher\Exception;

use Webit\MessageBus\Message;

interface MessagePublicationException extends \Throwable
{
    public function messageBusMessage(): Message;
}