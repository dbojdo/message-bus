<?php

namespace Webit\MessageBus\Consumer\Exception\Handler;

use Webit\MessageBus\Consumer\Exception\MessageConsumptionException;

final class IgnoringExceptionHandler implements ExceptionHandler
{
    /**
     * @inheritdoc
     */
    public function handle(MessageConsumptionException $exception)
    {
    }
}