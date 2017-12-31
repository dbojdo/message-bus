<?php

namespace Webit\MessageBus\Consumer\Exception;

use Webit\MessageBus\Message;

abstract class AbstractMessageConsumptionException extends \RuntimeException implements MessageConsumptionException
{
    /** @var Message */
    private $messageBusMessage;

    /**
     * @param Message $message
     * @param int $code
     * @param \Exception|null $previous
     * @return MessageConsumptionException
     */
    public static function forMessage(Message $message, $code = 0, \Exception $previous = null)
    {
        $exception = new static(
            static::createExceptionMessage($message),
            $code,
            $previous
        );

        $exception->messageBusMessage = $message;

        return $exception;
    }

    abstract protected static function createExceptionMessage(Message $message): string;

    /**
     * @return Message
     */
    public function messageBusMessage(): Message
    {
        return $this->messageBusMessage;
    }
}