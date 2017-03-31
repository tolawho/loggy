<?php

namespace Tolawho\Loggy\Stream;

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class Handler extends StreamHandler
{
    /**
     * @var string
     */
    protected $channel;

    /**
     * Handler constructor.
     *
     * @author tolawho
     * @param string $channel
     * @param resource|string $stream
     * @param bool|int $level
     * @param bool $bubble
     * @param null $filePermission
     * @param bool $useLocking
     */
    public function __construct(
        $channel,
        $stream,
        $level = Logger::DEBUG,
        $bubble = true,
        $filePermission = null,
        $useLocking = false
    ) {
        $this->channel = $channel;
        $formatter = new LineFormatter(null, null, false, true);
        $this->setFormatter($formatter);
        parent::__construct($stream, $level, $bubble, $filePermission, $useLocking);
    }

    /**
     * {@inheritdoc}
     */
    public function isHandling(array $record)
    {
        if (isset($record['channel'])) {
            return ($record['level'] >= $this->level && $record['channel'] == $this->channel);
        }
        return ($record['level'] >= $this->level);
    }
}
