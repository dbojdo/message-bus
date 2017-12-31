<?php

namespace Webit\MessageBus\Exception;

class UnregisteredPublisherException extends \OutOfBoundsException
{
    public static function fromPublisherName(string $name, int $code = 0, \Exception $previous = null)
    {
        return new self(
            sprintf('Publisher "%s" is not registered.', $name),
            $code,
            $previous
        );
    }
}
