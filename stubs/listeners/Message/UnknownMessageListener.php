<?php

namespace App\Listeners\Message;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use LINE\LINEBot\Event\MessageEvent\UnknownMessage;
use Bogiesoft\Line\Facades\Bot;

class UnknownMessageListener
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
     * @param  UnknownMessage  $event
     * @return void
     */
    public function handle(UnknownMessage $event)
    {
        //
    }
}
