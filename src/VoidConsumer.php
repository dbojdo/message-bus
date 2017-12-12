<?php

namespace Webit\MessageBus;

final class VoidConsumer implements Consumer
{
    /**
     * @inheritdoc
     */
    public function consume(Message $message)
    {
    }
}
