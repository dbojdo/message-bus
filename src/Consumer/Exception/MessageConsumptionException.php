<?php

namespace Webit\MessageBus\Consumer\Exception;

use Webit\MessageBus\Message;

interface MessageConsumptionException extends \Throwable
{
    public function messageBusMessage(): Message;
}
