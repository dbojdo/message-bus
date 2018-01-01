<?php

namespace Webit\MessageBus\Consumer\Exception\Handler;

use Webit\MessageBus\AbstractTestCase;
use Webit\MessageBus\Consumer\Exception\CannotConsumeMessageException;

class IgnoringExceptionHandlerTest extends AbstractTestCase
{
    /**
     * @test
     */
    public function itIgnoresException()
    {
        $handler = new IgnoringExceptionHandler();
        $exception = CannotConsumeMessageException::forMessage($this->randomMessage());
        $handler->handle($exception);

        $this->assertTrue(true);
    }
}
