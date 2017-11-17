<?php

namespace Mattlibera\Loggy\Events;

class LoggyMessageLogged
{
    /**
     * The log "channel".
     *
     * @var string
     */
    public $channel;

    /**
     * The log "level".
     *
     * @var string
     */
    public $level;

    /**
     * The log message.
     *
     * @var string
     */
    public $message;

    /**
     * The log context.
     *
     * @var array
     */
    public $context;

    /**
     * Create a new event instance.
     *
     * @param  string  $level
     * @param  string  $message
     * @param  array  $context
     * @return void
     */
    public function __construct($channel, $level, $message, array $context = [])
    {
        $this->channel = $channel;
        $this->level = $level;
        $this->message = $message;
        $this->context = $context;
    }
}
