<?php

namespace Webit\MessageBus\Publisher\Exception\Handler;

use Webit\MessageBus\Publisher\Exception\MessagePublicationException;

final class ThrowingExceptionHandler implements ExceptionHandler
{
    /**
     * @inheritdoc
     */
    public function handle(MessagePublicationException $exception)
    {
        throw $exception;
    }
}