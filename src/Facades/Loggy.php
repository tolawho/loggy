<?php

namespace Mattlibera\Loggy\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Loggy
 * @package Mattlibera\Loggy\Facades
 */
class Loggy extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'loggy';
    }
}
