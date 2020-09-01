<?php

namespace Tests\Feature;


use App\Reply;
use App\Thread;
use App\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use \Illuminate\Foundation\Testing\RefreshDatabase;

class BestReplyTest extends TestCase
{

    use RefreshDatabase;

    public function test_a_thread_creator_mark_a_reply_as_best()
    {
        $this->withExceptionHandling();

        $this->signIn();

        $thread = create(Thread::class,['user_id'=>auth()->id()]);

        $replies = create(Reply::class,['thread_id'=>$thread->id],2);

        $this->assertFalse($replies[1]->isBest());

        $this->postJson(route('best-replies.store',$replies[1]));

        $this->assertTrue($replies[1]->fresh()->isBest());
    }

    function test_only_the_thread_creator_may_mark_a_reply_as_best()
    {
        $this->withExceptionHandling();

        $this->signIn();
        $thread = create(Thread::class,['user_id'=>auth()->id()]);
        $replies = create(Reply::class,['thread_id'=>$thread->id],2);

        $this->signIn(create(User::class));

        $this->postJson(route('best-replies.store',$replies[1]))->assertStatus(403);

        $this->assertFalse($replies[1]->fresh()->isBest());

    }

    function test_if_a_best_reply_is_deleted_the_thread_is_updated()
    {
        $this->signIn();

        $reply = create(Reply::class,['user_id'=>auth()->id()]);

        $reply->thread->markBestReply($reply);

        $this->json('delete',route('replies.destroy',$reply));

        $this->assertNull(Thread::first()->best_reply_id);
    }

}
