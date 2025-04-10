# Laravel-Shortpixel
Laravel 5+ wrapper for ShortPixel API. A forked version of [davidcb/laravel-shortpixel](https://github.com/davidcb/laravel-shortpixel)

## Installation

Install via Composer:
```
composer require hkhasib/laravel-shortpixel
```

If you're using Laravel >= 5.5, you can skip this as this package will be auto-discovered. However, if you want, you can follow these steps for Laravel <=10:
Add the service provider to `config/app.php`
```php
Hkhasib\LaravelShortPixel\LaravelShortPixelServiceProvider::class,
```

You can register the facade in the `aliases` array in the `config/app.php` file
```php
'LaravelShortPixel' => Hkhasib\LaravelShortPixel\Facades\LaravelShortPixel::class,
```

For Laravel >=11, you can optionally follow these steps:

Add the service provider to 'bootstrap/providers.php'
```php
    return [
    #other providers
    \Hkhasib\LaravelShortPixel\LaravelShortPixelServiceProvider::class,
];
```
Add the alias to 'bootstrap/app.php'
```php
    $middleware->alias([
            #other aliases
           'LaravelShortPixel'=>\Hkhasib\LaravelShortPixel\Facades\LaravelShortPixel::class,
        ]);
```

After adding these things on your laravel app for Laravel <=10 and Laravel >=11, follow these steps:

Publish the config file
```
php artisan vendor:publish --provider="Hkhasib\LaravelShortPixel\LaravelShortPixelServiceProvider"
```

Set your API key on your .env file
```
SHORT_PIXEL_API_KEY=secret
```

## Usage

You can find all the methods in the original [short-pixel-optimizer/shortpixel-php package](https://github.com/short-pixel-optimizer/shortpixel-php) and [davidcb/laravel-shortpixel](https://github.com/davidcb/laravel-shortpixel).

My package is exactly same as David. But, my one automatically generate webp by default. Also, I have added a refresh method.

So, if you want to refresh a previously optimized version of image, you can do it in following way:

```php
//optimize with refresh
$result = LaravelShortPixel::fromUrls('https://your.site/img/unoptimized.png', '/path/to/save/to', 'filename.png', $compression_level = 1, $width = 200, $height = 200, $maxDimension = true, $refresh=true]);

```
Just set $refresh = false or ignore it completely as it is false by default if you don't want to refresh.

Alternatively, you can use refreshFromUrls method to refresh the optimized image.

```php
$result = LaravelShortPixel::refreshfromUrls('https://your.site/img/unoptimized.png', '/path/to/save/to', 'filename.png', $compression_level = 1, $width = 200, $height = 200, $maxDimension = true
```
fromFiles, fromUrls, fromFolder, refreshFromFiles, refreshFromUrls, refreshFromFolder methods are available in this package.

The usage are same as the original package. Only the refresh methods are added in this package.




The compression_level, width, height and maxDimension are optional. Compression levels are 0 - loseless, 1 - lossy, 2- glossy. Default compression level for your images is set on the configuration file (lossy is set as default).
