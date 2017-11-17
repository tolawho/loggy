<?php

return [

    'fire_event' => true, // set to false if Loggy should not fire LoggyMessageLogged event upon writing to logs

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
