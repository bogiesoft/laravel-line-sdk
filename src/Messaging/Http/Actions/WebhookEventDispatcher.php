<?php

namespace Bogiesoft\Line\Messaging\Http\Actions;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Bogiesoft\Line\Contracts\WebhookHandler;
use Bogiesoft\Line\Facades\Bot;

class WebhookEventDispatcher implements WebhookHandler
{
    /**
     * @param  Request  $request
     * @return Response
     */
    public function __invoke(Request $request)
    {
        Bot::parseEvent($request)->each(function ($event) {
            event($event);
        });

        return response(class_basename(static::class));
    }
}
