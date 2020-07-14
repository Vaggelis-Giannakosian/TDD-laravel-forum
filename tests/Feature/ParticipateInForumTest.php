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

        $this->expectException('Illuminate\Auth\AuthenticationException');

        $thread = create(Thread::class);
        $this->withoutExceptionHandling()->post("/threads/{$thread->id}/replies",[]);
    }

    public function test_an_auth_user_may_participate_in_forum_threads()
    {

        $this->signIn($user = create(User::class));
        $thread = create(Thread::class);
        $reply = make(Reply::class);

        $this->get($thread->path())->assertDontSee($reply->body);

        $postRequest = $this->post("/threads/{$thread->id}/replies",$reply->toArray());
        $postRequest->assertStatus(302);

        $this->get($thread->path())->assertSee($reply->body);
    }
}
