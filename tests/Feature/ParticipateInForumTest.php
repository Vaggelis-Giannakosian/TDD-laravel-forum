<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{

    use RefreshDatabase;

    public function test_an_unauthenticated_user_may_not_participate_in_forum_threads()
    {
        $this->withExceptionHandling();

        $thread = create(Thread::class);
        $this->post($thread->path()."/replies",[])->assertRedirect(route('login'));
    }

    public function test_an_auth_user_may_participate_in_forum_threads()
    {

        $this->signIn($user = create(User::class));
        $thread = create(Thread::class);
        $reply = make(Reply::class);

        $this->get($thread->path())->assertDontSee($reply->body);

        $postRequest = $this->post($thread->path()."/replies",$reply->toArray());
        $postRequest->assertStatus(302);

        $this->get($thread->path())->assertSee($reply->body);
    }

    public function test_a_reply_requires_a_body()
    {
        $this->withExceptionHandling();

        $this->signIn();
        $thread = create(Thread::class);
        $reply = make(Reply::class,['body'=>null]);

        $this->post($thread->path()."/replies",$reply->toArray())->assertSessionHasErrors('body');
    }
}
