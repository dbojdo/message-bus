<?php

namespace Webit\MessageBus;

final class Message
{
    /** @var string */
    private $type;
    
    /** @var string */
    private $content;

    /**
     * Message constructor.
     * @param string $type
     * @param string $content
     */
    public function __construct(string $type, string $content)
    {
        $this->type = $type;
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function type(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function content(): string
    {
        return $this->content;
    }

    /**
     * @inheritdoc
     */
    public function __toString()
    {
        return $this->content();
    }
}