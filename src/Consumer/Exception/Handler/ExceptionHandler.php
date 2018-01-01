<?php

namespace Webit\MessageBus\Consumer\Exception\Handler;

use Webit\MessageBus\Consumer\Exception\MessageConsumptionException;

interface ExceptionHandler
{
    /**
     * @param MessageConsumptionException $exception
     * @throws MessageConsumptionException
     */
    public function handle(MessageConsumptionException $exception);
}