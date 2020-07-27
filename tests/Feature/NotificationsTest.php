<?php

namespace Tests\Feature;

use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NotificationsTest extends TestCase
{

    use RefreshDatabase;

    public function test_a_notification_is_created_when_a_subscribed_thread_receives_a_new_reply()
    {
        $this->signIn();

        //given we have a thread
        $thread = create(Thread::class)->subscribe();

        $this->assertCount(0, auth()->user()->notifications);

        //each time there is a new reply...
        $thread->addReply([
            'user_id' => auth()->id(),
            'body' => 'Some reply'
        ]);

        //A notifications is sent to the user
        $this->assertCount(0, auth()->user()->fresh()->notifications);

        //each time there is a new reply...
        $thread->addReply([
            'user_id' => create(User::class)->id,
            'body' => 'Some reply'
        ]);

        //A notifications is sent to the user
        $this->assertCount(1, auth()->user()->fresh()->notifications);
    }

    function test_a_user_can_mark_a_notification_as_read()
    {
        $this->signIn();

        //given we have a thread
        $thread = create(Thread::class)->subscribe();

        //each time there is a new reply...
        $thread->addReply([
            'user_id' => create(User::class)->id,
            'body' => 'Some reply'
        ]);

        //A notifications is sent to the user
        $notifications = auth()->user()->fresh()->unreadNotifications;
        $this->assertCount(1, $notifications);


        $this->delete(route('user-notifications.delete',[auth()->user(),$notifications->first()->id]));

        //A notifications is sent to the user
        $this->assertCount(0, auth()->user()->fresh()->unreadNotifications);
        $this->assertCount(1, auth()->user()->fresh()->readNotifications);
    }

    function test_a_user_can_fetch_their_unread_notifications()
    {
        $this->signIn();

        //given we have a thread
        $thread = create(Thread::class)->subscribe();


        //each time there is a new reply...
        $thread->addReply([
            'user_id' => create(User::class)->id,
            'body' => 'Some reply'
        ]);

        $response = $this->getJson(route('user-notifications.index',[auth()->user()]))->json();

        $this->assertCount(1,$response);
    }

}
