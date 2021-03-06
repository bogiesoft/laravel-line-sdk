<?php

namespace App\Listeners\Message;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use LINE\LINEBot\Event\MessageEvent\StickerMessage;
use LINE\LINEBot\MessageBuilder\StickerMessageBuilder;
use Bogiesoft\Line\Facades\Bot;

class StickerMessageListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  StickerMessage  $event
     * @return void
     */
    public function handle(StickerMessage $event)
    {
        $packageId = $event->getPackageId();
        $stickerId = $event->getStickerId();

        Bot::replyMessage($event->getReplyToken(), new StickerMessageBuilder($packageId, $stickerId));
    }
}
