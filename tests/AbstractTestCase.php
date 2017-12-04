<?php

namespace Webit\MessageBus;

use PHPUnit\Framework\TestCase;

abstract class AbstractTestCase extends TestCase
{
    /**
     * @return string
     */
    protected function randomString()
    {
        return md5(mt_rand(0, 10000000).microtime());
    }

    /**
     * @return Message
     */
    protected function randomMessage()
    {
        return new Message($this->randomString(), $this->randomString());
    }
}