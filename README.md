# LINE SDK for Laravel


## Features
- Working with Laravel Event System. Including Webhook routing and controller.
- Extensible Bot Client.
- Working with Laravel Notification System(LINE Notify)
- Including Socialite drivers(LINE Login, LINE Notify)

## Requirements
- PHP >= 8.0
- Laravel >= 9.0

## Versioning
- Basic : semver
- Drop old PHP or Laravel version : `+0.1`. composer should handle it well.
- Support only latest major version (`master` branch), but you can PR to old branches.

## Installation

```
composer require bogiesoft/laravel-line-sdk
```

## Configuration

### .env
Set up in LINE Developers console.
https://developers.line.biz/

Create two channels `Messaging API` and `LINE Login`.

- Messaging API : Get `Channel access token (long-lived)` and `Channel secret`. Set `Webhook URL`
- LINE Login : Get `Channel ID` and `Channel secret`. Set `Callback URL`

```
LINE_BOT_CHANNEL_TOKEN=
LINE_BOT_CHANNEL_SECRET=

LINE_LOGIN_CLIENT_ID=
LINE_LOGIN_CLIENT_SECRET=
LINE_LOGIN_REDIRECT=

LINE_NOTIFY_CLIENT_ID=
LINE_NOTIFY_CLIENT_SECRET=
LINE_NOTIFY_REDIRECT=
LINE_NOTIFY_PERSONAL_ACCESS_TOKEN=
```

### Publishing(Optional)

```
php artisan vendor:publish --tag=line-config
```

### Short Facade(Optional)
Recent Laravel uses a full namespace.

```php
use Bogiesoft\Line\Facades\Bot;

Bot::replyText();
```

If you want to use the short Facade, you can add it manually in `config/app.php`.

```php
    'aliases' => [
        'LINE' => Bogiesoft\Line\Facades\Bot::class,
    ],
```

```php
use LINE;

LINE::replyText();
```

## Quick Start

### Prepare
- Create `Messaging API` channel in LINE Developers console.
- Get `Channel access token (long-lived)`, `Channel secret` and QR code.
- A web server that can receive webhooks from LINE. Not possible on a normal local server.

### Create new Laravel project
```
composer create-project --prefer-dist laravel/laravel line-bot "8.*"
cd ./line-bot
composer require bogiesoft/laravel-line-sdk
```

Edit `.env`

```
LINE_BOT_CHANNEL_TOKEN=
LINE_BOT_CHANNEL_SECRET=
```

Add `shouldDiscoverEvents()` to `app/Providers/EventServiceProvider`
```php
/**
 * Determine if events and listeners should be automatically discovered.
 *
 * @return bool
 */
public function shouldDiscoverEvents()
{
    return true;
}
```

Publishing default Listeners
```
php artisan vendor:publish --tag=line-listeners-message
```

### Deploy to web server
- Set `Webhook URL` in LINE Developers console. `https://example.com/line/webhook`
- Verify Webhook URL.

### Add bot as a friend.
- Using QR code.

### Send test message
Bot returns same message.

## Documents
- [Messaging API / Bot](./docs/bot.md)
- [Socialite](./docs/socialite.md)
- [Notifications](./docs/notify.md)

## Demo


## LICENSE
MIT
