Supports [Laravel 5](http://laravel.com/) writing separate log files with multiple channel.
[![License](https://poser.pugx.org/tolawho/loggy/license)](https://packagist.org/packages/tolawho/loggy)

# Matt's Fork

This is a fork of the original package. Current added features:

- Fires a `LoggyMessageLogged` event upon writing to logs. You can listen to this event and take action on it accordingly if parameters match. For instance, if a log was written to a certain channel, or was a certain level, you could then fire off an email or text message to system administrators. 

# Requirements

Loggy >= 1.0.0 requires Laravel 5.

# Installation

Currently must be added manually as a repo to `composer.json` - not available on Packagist.

# Quick Start

Once Composer has installed or updated your packages you need to register `Loggy` with Laravel itself. Open up `config/app.php` and find the providers key, towards the end of the file, and add `Mattlibera\Loggy\ServiceProvider:class`, to the end:

```php
'providers' => [
    ...
    Mattlibera\Loggy\ServiceProvider::class,
],
```

Now find the aliases key, again towards the end of the file, and add `'Loggy' => Mattlibera\Loggy\Facades\Loggy::class`, to have easier access to the `Loggy`:

```php
'aliases' => [
    ... 
    'Loggy' => Mattlibera\Loggy\Facades\Loggy::class,
],
```

Now that you have both of those lines added to `config/app.php` we will use `Artisan` to publish the new config file:

```php
php artisan vendor:publish --provider="Mattlibera\Loggy\ServiceProvider"
```

The example config:

```php
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

```

Explain:

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

# Configuration

Once Composer has installed or updated your packages you need to register `Loggy` with Laravel itself. Open up `config/app.php` and find the providers key towards the bottom and add:

```php
Mattlibera\Loggy\ServiceProvider::class,
```

You can add the Loggy Facade, to have easier access to the `Loggy`.

```php
'Loggy' => Mattlibera\Loggy\Facades\Loggy::class
```

You can find the default configuration file at `vendor/tolawho/loggy/src/config.php`.  

You _should_ use Artisan to copy the default configuration file from the `/vendor` directory to `/config/loggy.php` with the following command:

```php
php artisan vendor:publish --provider="Mattlibera\Loggy\ServiceProvider"
```

# Usage

You call the `Loggy` like you would:

```php
Loggy::write('payment', 'Somthing 1...', ['something 1']);
Loggy::info('payment', 'Somthing 2..', ['something 2']);
```
