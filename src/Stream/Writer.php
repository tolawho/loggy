<?php

namespace Tolawho\Loggy\Stream;

use Monolog\Logger;

/**
 * Class Writer
 * @package Tolawho\Loggy\Stream
 */
class Writer
{

    /**
     * @var array
     */
    protected $logger = [];

    /**
     * @var array
     */
    protected $channels = [];

    /**
     * @var array
     */
    protected $levels = [
        'debug'     => Logger::DEBUG,
        'info'      => Logger::INFO,
        'notice'    => Logger::NOTICE,
        'warning'   => Logger::WARNING,
        'error'     => Logger::ERROR,
        'critical'  => Logger::CRITICAL,
        'alert'     => Logger::ALERT,
        'emergency' => Logger::EMERGENCY,
    ];

    /**
     * Writer constructor.
     */
    public function __construct()
    {
        $this->loadChannels();
    }

    /**
     * Write out message by channel
     *
     * @author tolawho
     * @param string $channel
     * @param string $message
     * @param array $context
     * @return void
     */
    public function write($channel, $message, array $context = [])
    {
        $level = $this->channels[$channel]['level'];
        $this->put($channel, $level, $message, $context);
    }

    /**
     * Call level logger
     *
     * @author tolawho
     * @param string $fnc
     * @param array $arguments
     * @return void
     */
    function __call($fnc, $arguments)
    {
        if ($this->levelExist($fnc)) {
	        $context = isset( $arguments[2] ) ? $arguments[2] : [];
	        $message = isset( $arguments[1] ) ? $arguments[1] : '';
	        $this->put( $arguments[0], $fnc, $message, $context );
        }
    }

    /**
     * Write to log based on the given channel and level
     *
     * @author tolawho
     * @param string $channel
     * @param bool|int $level
     * @param string $message
     * @param array $context
     * @return void
     */
    private function put($channel, $level, $message, array $context = [])
    {
        if (!$this->channelExist($channel)) {
            throw new \InvalidArgumentException("The channel named $channel is not exist.");
        }

        if (!isset($this->logger[$channel])) {
            $this->logger[$channel] = new Logger($channel);
            $this->logger[$channel]->pushHandler(
                new Handler(
                    $channel,
                    storage_path(sprintf('logs/%s', $this->channels[$channel]['log'])),
                    $this->channels[$channel]['level']
                )
            );
        }

        $this->logger[$channel]->{$level}($message, $context);
    }

    /**
     * Load channel from config file
     *
     * @author tolawho
     * @return void
     */
    private function loadChannels()
    {
        $channels = config('loggy.channels');

        if (!is_array($channels)) $channels = [];

        foreach ($channels as $channel => &$config) {
            if (!isset($config['log']) || !$config['log']) {
                $config['log'] = $channel . '.log';
            }

            if (isset($config['daily']) && $config['daily'] === true) {
                $config['log'] = sprintf('%s-%s.log', str_replace('.log', '', $config['log']), date('Y-m-d'));
            }
        }

        $this->channels = $channels;
    }

    /**
     * Check channel exist
     *
     * @author tolawho
     * @param string $channel
     * @return bool
     */
    private function channelExist($channel)
    {
        return array_key_exists($channel, $this->channels);
    }

    /**
     * Check level exist
     *
     * @author tolawho
     * @param string $level
     * @return bool
     */
    private function levelExist($level)
    {
        return array_key_exists($level, $this->levels);
    }
}
