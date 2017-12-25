<?php

namespace Webit\MessageBus;

use Webit\MessageBus\Exception\UnregisteredPublisherException;

interface PublisherRegistry
{
    /**
     * @param string $name
     * @return Publisher
     * @throws UnregisteredPublisherException
     */
    public function getPublisher(string $name): Publisher;
}
