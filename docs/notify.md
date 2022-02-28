# LINE Notify

https://notify-bot.line.me/

## .env
```
LINE_NOTIFY_CLIENT_ID=
LINE_NOTIFY_CLIENT_SECRET=
LINE_NOTIFY_REDIRECT=
LINE_NOTIFY_PERSONAL_ACCESS_TOKEN=
```

## Create Notification
```
php artisan make:notification LineNotifyTest
```

Add `LineNotifyChannel` and `toLineNotify()`

```php
<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Bogiesoft\Line\Notifications\LineNotifyChannel;
use Bogiesoft\Line\Notifications\LineNotifyMessage;

class LineNotifyTest extends Notification
{
    use Queueable;

    /**
     * @var string
     */
    protected $message;

    /**
     * Create a new notification instance.
     *
     * @param  string  $message
     *
     * @return void
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [
            LineNotifyChannel::class
        ];
    }

    /**
     * @param  mixed  $notifiable
     * @return LineNotifyMessage
     */
    public function toLineNotify($notifiable)
    {
        return LineNotifyMessage::create($this->message);
    }
}
```

## LineNotifyMessage

```php
use Bogiesoft\Line\Notifications\LineNotifyMessage;

return LineNotifyMessage::create('message')
            ->withSticker(1, 1)
            ->with([
                'imageThumbnail' => 'https://',
            ]);
```

```php
return (new LineNotifyMessage())->message('message')
            ->withSticker(1, 2)
            ->with([
                'imageFullsize' => 'https://',
            ]);
```

Only some stickers can be used.  
https://devdocs.line.me/files/sticker_list.pdf

## User access token

Get user access token by using [Socialite](./socialite.md).

### User model
```php
    /**
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return string
     */
    public function routeNotificationForLineNotify($notification)
    {
        return $this->notify_token;
    }
```

### Send notifications to user
```php
$user->notify(new LineNotifyTest('test'));
```

## Personal access token
If you're only going to use a specific notifier for on-demand notifications

```php
use Illuminate\Support\Facades\Notification;
use App\Notifications\LineNotifyTest;

Notification::route('line-notify', config('line.notify.personal_access_token'))
            ->notify(new LineNotifyTest('test'));
```

## LINE Notify API
```php
use Bogiesoft\Line\Facades\LineNotify;

$res = LineNotify::withToken($token)->notify($params);
$res = LineNotify::withToken($token)->status();
$res = LineNotify::withToken($token)->revoke();  // ยกเลิก Token
```


Demo  Laravel Notification system.
```php
use Bogiesoft\Line\Facades\LineNotify;

    $message = "\n\r"; 
    $message.= 'รหัสสมาชิก : MB789456 '."\r\n"; 
    $message.= 'ชื่อสมาชิก : คุณ เก่ง นครชัย'."\r\n" ; 
    $message.= 'หมายเลขโทรศัพท์: 0000000000'."\r\n" ;        
    $message.= 'ธนาคาร : กสิกรไทย'."\r\n" ; 
    $message.= 'เลขที่บัญชี : 01234567891234566 '."\r\n" ; 
    $message.= 'เงินฝากเปิดบัญชี : 0 '."\r\n" ;  
    $message.= 'ช่องทางการสมัคร : APIs'."\r\n" ; 
    $message.= 'ประเภทสมาชิก : ทั่วไป'."\r\n" ;  
    $message.= 'ไลน์ไอดี : KengIT '."\r\n" ; 
    
    
$arr_message = array(
  'message' => $message,
  'imageThumbnail' => 'https://www.boonsit.com/uploads/img/general/1631072863-logo.png',  // max size 240x240px JPEG
  'imageFullsize' => 'https://www.boonsit.com/uploads/img/general/1631072863-logo.png', //max size 1024x1024px JPEG
  'imageFile' => '',
  'stickerPackageId' => '',
  'stickerId' => ''
 
    );

$resNotify = LineNotify::withToken($token)->notify($arr_message);

```

Without Laravel Notification system.
```php
use Bogiesoft\Line\Facades\LineNotify;
use Bogiesoft\Line\Notifications\LineNotifyMessage;

$message = LineNotifyMessage::create('message');

$res = LineNotify::withToken($token)->notify($message->toArray());
```


