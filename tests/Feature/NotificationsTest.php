<?php

namespace Tests\Feature;

use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use \Illuminate\Notifications\DatabaseNotification;
use Tests\TestCase;

class NotificationsTest extends TestCase
{

    use RefreshDatabase;

    protected $thread;


    public function setUp(): void
    {
        parent::setUp();
        $this->signIn();
    }

    public function test_a_notification_is_created_when_a_subscribed_thread_receives_a_new_reply()
    {

        $this->assertCount(0, auth()->user()->notifications);

        $thread = create(Thread::class)->subscribe();
            
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

        create(DatabaseNotification::class);


        tap(auth()->user(),function($user){
            //A notifications is sent to the user
            $this->assertCount(1, $user->unreadNotifications);

            $this->delete(route('user-notifications.delete',[$user,$user->unreadNotifications->first()->id]));

            //A notifications is sent to the user
            $this->assertCount(0, $user->fresh()->unreadNotifications);
            $this->assertCount(1, $user->fresh()->readNotifications);
        });
    }

    function test_a_user_can_fetch_their_unread_notifications()
    {
        create(DatabaseNotification::class);
        $this->assertCount(
            1,
            $this->getJson(route('user-notifications.index',[auth()->user()]))->json()
        );
    }

}
