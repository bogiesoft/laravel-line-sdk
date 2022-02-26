<?php

namespace Bogiesoft\Line\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Socialite\Facades\Socialite;
use Bogiesoft\Line\Socialite\LineLoginProvider;
use Bogiesoft\Line\Socialite\LineNotifyProvider;

class LineSocialiteServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Socialite::extend('line-login', function () {
            return Socialite::buildProvider(LineLoginProvider::class, config('line.login'));
        });

        Socialite::extend('line-notify', function () {
            return Socialite::buildProvider(LineNotifyProvider::class, config('line.notify'));
        });
    }
}
