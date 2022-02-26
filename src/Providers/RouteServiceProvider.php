<?php

namespace Bogiesoft\Line\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Bogiesoft\Line\Messaging\Http\Controllers\WebhookController;
use Bogiesoft\Line\Messaging\Http\Middleware\ValidateSignature;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Route::middleware(config('line.bot.middleware'))
            ->domain(config('line.bot.domain'))
            ->group(function () {
                Route::post(config('line.bot.path', 'line/webhook'))
                    ->name(config('line.bot.route', 'line.webhook'))
                    ->middleware(ValidateSignature::class)
                    ->uses(WebhookController::class);
            });
    }
}
