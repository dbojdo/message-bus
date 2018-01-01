<?php

namespace Webit\MessageBus\Consumer\Exception\Handler;

use Webit\MessageBus\AbstractTestCase;
use Webit\MessageBus\Consumer\Exception\CannotConsumeMessageException;
use Webit\MessageBus\Consumer\Exception\MessageConsumptionException;

class ThrowingExceptionHandlerTest extends AbstractTestCase
{
    /**
     * @test
     */
    public function itThrowsAnException()
    {
        $handler = new ThrowingExceptionHandler();
        $exception = CannotConsumeMessageException::forMessage($this->randomMessage());

        try {
            $handler->handle($exception);
        } catch (MessageConsumptionException $e) {
            $this->assertSame($exception, $e);
            return;
        }

        $this->assertTrue(false, 'Expected exception has not been thrown.');
    }
}
