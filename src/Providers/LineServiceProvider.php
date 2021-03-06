<?php

namespace Bogiesoft\Line\Providers;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use LINE\LINEBot;
use LINE\LINEBot\HTTPClient;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use Bogiesoft\Line\Contracts\BotFactory;
use Bogiesoft\Line\Contracts\NotifyFactory;
use Bogiesoft\Line\Contracts\WebhookHandler;
use Bogiesoft\Line\Messaging\BotClient;
use Bogiesoft\Line\Messaging\Http\Actions\WebhookEventDispatcher;
use Bogiesoft\Line\Notifications\LineNotifyClient;

class LineServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/line.php',
            'line'
        );

        $this->registerBot();

        $this->registerNotify();

        $this->registerWebhookHandler();
    }

    /**
     * Bot.
     *
     * @return void
     */
    protected function registerBot()
    {
        $this->app->singleton(HTTPClient::class, function ($app) {
            return new CurlHTTPClient(config('line.bot.channel_token'));
        });

        $this->app->singleton(LINEBot::class, function ($app) {
            return new LINEBot(app(HTTPClient::class), [
                'channelSecret' => config('line.bot.channel_secret'),
            ]);
        });

        $this->app->singleton(BotFactory::class, BotClient::class);
    }

    /**
     * Notify.
     *
     * @return void
     */
    protected function registerNotify()
    {
        $this->app->singleton(NotifyFactory::class, function ($app) {
            return new LineNotifyClient(app(Client::class));
        });
    }

    /**
     * Default WebhookHandler.
     *
     * @return void
     */
    protected function registerWebhookHandler()
    {
        $this->app->singleton(WebhookHandler::class, WebhookEventDispatcher::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->configurePublishing();
    }

    /**
     * Configure publishing for the package.
     *
     * @return void
     */
    protected function configurePublishing()
    {
        if (! $this->app->runningInConsole()) {
            return; // @codeCoverageIgnore
        }

        $this->publishes([
            __DIR__.'/../../config/line.php' => $this->app->configPath('line.php'),
        ], 'line-config');

        $this->publishes([
            __DIR__.'/../../stubs/listeners' => $this->app->path('Listeners'),
        ], 'line-listeners-all');

        $this->publishes([
            __DIR__.'/../../stubs/listeners/Message' => $this->app->path('Listeners/Message'),
        ], 'line-listeners-message');
    }
}
