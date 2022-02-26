# Laravel-based framework

Manually add some ServiceProviders.

## Lumen

`bootstrap/app.php`

```php
$app->register(Bogiesoft\Line\Providers\LineServiceProvider::class);
$app->register(Bogiesoft\Line\Providers\MacroServiceProvider::class);// Laravel>=7

// If you use webhook.
$app->router->group(
    [
        'middleware' => Bogiesoft\Line\Messaging\Http\Middleware\ValidateSignature::class,
    ],
    function ($router) {
        $router->post(
            config('line.bot.path'),
            Bogiesoft\Line\Messaging\Http\Controllers\WebhookController::class
        );
    }
);
```

## Laravel Zero

`config/app.php`

```php
    'providers' => [
        //

        Bogiesoft\Line\Providers\LineServiceProvider::class,
        Bogiesoft\Line\Providers\MacroServiceProvider::class,// Laravel>=7
    ],
```
