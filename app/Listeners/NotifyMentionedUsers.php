<?php

namespace App\Listeners;

use App\Events\ThreadHasNewReply;
use App\Notifications\YourWereMentioned;
use App\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyMentionedUsers
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
     * @param  object  $event
     * @return void
     */
    public function handle(ThreadHasNewReply $event)
    {
        collect($event->reply->mentionedUsers())
            ->map(fn($name)=>User::where('name',$name)->first())
            ->filter()
            ->each
            ->notify(new YourWereMentioned($event->reply));
    }
}
