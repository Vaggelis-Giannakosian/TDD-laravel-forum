<?php

namespace App\Listeners;

use App\Events\ThreadHasNewReply;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyThreadSubscribers
{

    /**
     * Handle the event.
     *
     * @param  ThreadHasNewReply  $event
     * @return void
     */
    public function handle(ThreadHasNewReply $event)
    {
        $event->thread->subscriptions
            ->where('user_id' ,'!=', $event->reply->user_id)
            ->each
            ->notify($event->reply);
    }
}
