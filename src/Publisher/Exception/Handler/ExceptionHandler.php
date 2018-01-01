<?php

namespace Webit\MessageBus\Publisher\Exception\Handler;

use Webit\MessageBus\Publisher\Exception\MessagePublicationException;

interface ExceptionHandler
{
    /**
     * @param MessagePublicationException $exception
     * @throws MessagePublicationException
     */
    public function handle(MessagePublicationException $exception);
}