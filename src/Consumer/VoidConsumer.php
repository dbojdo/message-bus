<?php

namespace Webit\MessageBus\Consumer;

use Webit\MessageBus\Consumer;
use Webit\MessageBus\Message;

final class VoidConsumer implements Consumer
{
    /**
     * @inheritdoc
     */
    public function consume(Message $message)
    {
    }
}
