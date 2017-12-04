<?php

namespace Webit\MessageBus\Exception;

use Webit\MessageBus\Message;

class MessageConsumptionException extends \RuntimeException
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
        $exception = new self(
            sprintf('Error during consumption of the message of type "%s".', $message->type()),
            $code,
            $previous
        );

        $exception->messageBusMessage = $message;

        return $exception;
    }

    /**
     * @return Message
     */
    public function messageBusMessage(): Message
    {
        return $this->messageBusMessage;
    }
}
