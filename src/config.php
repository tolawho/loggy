<?php

return [
    'channels' => [
        'event' => [
            'log' => 'event.log',
            'daily' => false,
            'level' => 'debug'
        ],
        'payment' => [
            'log' => 'payment.log',
            'daily' => true,
            'level' => 'info'
        ],
    ]
];
