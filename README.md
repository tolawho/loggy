Supports [Laravel 5](http://laravel.com/) writing separate log files with multiple channel.

[![Latest Stable Version](https://poser.pugx.org/tolawho/loggy/v/stable)](https://packagist.org/packages/tolawho/loggy)
[![Total Downloads](https://poser.pugx.org/tolawho/loggy/downloads)](https://packagist.org/packages/tolawho/loggy)
[![License](https://poser.pugx.org/tolawho/loggy/license)](https://packagist.org/packages/tolawho/loggy)

# Requirements

Loggy >= 1.0.0 requires Laravel 5.

# Installation

Require this package with Composer

```bash
composer require tolawho/loggy
```
# Quick Start

## Laravel 5.5+

This package is updated for package auto-discovery in Laravel 5.5+. When using Laravel 5.5+ you do not need to register the service provider or the alias.

## Laravel 5.4 and below

Once Composer has installed or updated your packages you need to register `Loggy` with Laravel itself. Open up `config/app.php` and find the providers key, towards the end of the file, and add `Tolawho\Loggy\ServiceProvider:class`, to the end:

```php
'providers' => [
    ...
    Tolawho\Loggy\ServiceProvider::class,
],
```

Now find the aliases key, again towards the end of the file, and add `'Loggy' => Tolawho\Loggy\Facades\Loggy::class`, to have easier access to the `Loggy`:

```php
'aliases' => [
    ... 
    'Loggy' => Tolawho\Loggy\Facades\Loggy::class,
],
```

## All versions of Laravel

Use `Artisan` to publish the new config file:

```php
php artisan vendor:publish --provider="Tolawho\Loggy\ServiceProvider"
```

The example config:

```php
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

```

Explain:

* *fire_event*: If false, then the LoggyMessageLogged event will not be fired when a message is written.

* *channels.event*: The `event` is name of channel do you want. Ex `payment`, `audit`
* *channels.event.log*: The name of log file.
* *channels.event.daily*: True if you want write log file daily like as `event-2017-03-31.log`.
* *channels.event.level*: `debug`, `info`, `notice`, `warning`, `error`,`critical`,`alert`,`emergency`

At this point you can now begin using `Loggy`

```php
<?php
 
namespace App\Http\Controllers;
 
use Loggy; 
 
class HomeController extends Controller
{

    public function index()
    {
        Loggy::write('event', 'Ah hihi đồ ngốc');
        Loggy::debug('event', 'Ah hihi đồ ngốc');
        Loggy::info('event', 'Ah hihi đồ ngốc');
        
        return view('welcome');
    }
}
```

# Usage

You call the `Loggy` like you would:

```php
Loggy::write('payment', 'Somthing 1...', ['something 1']);
Loggy::info('payment', 'Somthing 2..', ['something 2']);
```

# Event

Upon writing to the logs an instance of `Events\LoggyMessageLogged` is fired. You can write your own Listeners to take action - the event will contain the complete data about the log message:

```php

// Events\LoggyMessageLogged

public function __construct($channel, $level, $message, array $context = [])
{
    $this->channel = $channel;
    $this->level = $level;
    $this->message = $message;
    $this->context = $context;
}
```

If you wish to disable this, you can do so in the config file, by setting the `fire_event` key to `false`.