<?php

namespace Webit\MessageBus\Publisher\Exception\Handler;

use Webit\MessageBus\AbstractTestCase;
use Webit\MessageBus\Publisher\Exception\CannotPublishMessageException;

class IgnoringExceptionHandlerTest extends AbstractTestCase
{
    /**
     * @test
     */
    public function itIgnoresExceptions()
    {
        $handler = new IgnoringExceptionHandler();
        $handler->handle(CannotPublishMessageException::forMessage($this->randomMessage()));
        $this->assertTrue(true);
    }
}
