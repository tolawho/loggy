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

Now that you have both of those lines added to `config/app.php` we will use `Artisan` to publish the new config file:

```php
php artisan vendor:publish --provider="Tolawho\Loggy\ServiceProvider"
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
Tolawho\Loggy\ServiceProvider::class,
```

You can add the Loggy Facade, to have easier access to the `Loggy`.

```php
'Loggy' => Tolawho\Loggy\Facades\Loggy::class
```

You can find the default configuration file at `vendor/tolawho/loggy/src/config.php`.  

You _should_ use Artisan to copy the default configuration file from the `/vendor` directory to `/config/loggy.php` with the following command:

```php
php artisan vendor:publish --provider="Tolawho\Loggy\ServiceProvider"
```

# Usage

You call the `Loggy` like you would:

```php
// Without the file extension
Loggy::write('payment', 'Somthing 1...', ['something 1']);
Loggy::info('payment', 'Somthing 2..', ['something 2']);
```