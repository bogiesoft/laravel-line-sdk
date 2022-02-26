<?php

namespace Bogiesoft\Line\Messaging\Http\Actions;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Bogiesoft\Line\Contracts\WebhookHandler;

class WebhookNullHandler implements WebhookHandler
{
    /**
     * @param  Request  $request
     * @return Response
     */
    public function __invoke(Request $request)
    {
        // null

        return response(class_basename(static::class));
    }
}
