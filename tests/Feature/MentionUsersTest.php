<?php

namespace Tests\Feature;

use App\Notifications\YourWereMentioned;
use App\Reply;
use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class MentionUsersTest extends TestCase
{

    use RefreshDatabase;

    function test_mentioned_users_in_a_reply_are_notified()
    {
        $john = create(User::class,['name'=> 'JohnDoe']);
        $jane = create(User::class,['name'=> 'JaneDoe']);

        $this->signIn($john);

        $thread = create(Thread::class);

        $reply = make(Reply::class,['body'=>'@JaneDoe look at this. Also @FrankDoe']);

        $this->postJson($thread->path().'/replies',$reply->toArray());

        $this->assertCount(1,$jane->notifications);
    }

    function test_mentioned_users_in_a_reply_get_YouWereMentioned_Notification()
    {

        Notification::fake();

        $john = create(User::class,['name'=> 'JohnDoe']);
        $jane = create(User::class,['name'=> 'JaneDoe']);

        $this->signIn($john);

        $thread = create(Thread::class);

        $reply = make(Reply::class,['body'=>'@JaneDoe look at this. Also @FrankDoe']);

        $this->postJson($thread->path().'/replies',$reply->toArray());

        Notification::assertSentTo($jane,YourWereMentioned::class);
    }

    function test_it_can_fetch_all_mentioned_users_starting_with_the_given_characters()
    {

        $john = create(User::class,['name'=> 'JohnDoe']);
        $jane = create(User::class,['name'=> 'JaneDoe']);

        $this->getJson(route('api.users.index',['name'=>'j']))->assertJson([
            'JohnDoe','JaneDoe'
        ]);

        $this->getJson(route('api.users.index',['name'=>'john']))->assertJsonCount(1);
        $this->getJson(route('api.users.index',['name'=>'ff']))->assertJsonCount(0);
    }

}
