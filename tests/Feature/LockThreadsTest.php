<?php

namespace Tests\Feature;


use App\Reply;
use App\Thread;
use App\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use \Illuminate\Foundation\Testing\RefreshDatabase;

class LockThreadsTest extends TestCase
{

    use RefreshDatabase;

    public function test_locked_threads_may_not_receive_new_replies()
    {
        $this->signIn();

        $thread = create(Thread::class);

        $thread->lock();

        $this->postJson($thread->path().'/replies',[
            'body'=>'Foobar',
            'user_id'=>create(User::class)->id
        ])->assertStatus(422);

    }

    function test_non_admin_may_not_lock_threads()
    {
        $this->signIn();

        $thread = create(Thread::class);

        $this->postJson(route('locked-threads.store',$thread))->assertStatus(403);

        $this->assertFalse((bool) $thread->fresh()->locked);
    }

    function test_admin_can_lock_any_thread()
    {
        $this->signIn(create(User::class,['admin'=>true]));

        $thread = create(Thread::class);

        $this->postJson(route('locked-threads.store',$thread))->assertStatus(200);

        $this->assertTrue((bool) $thread->fresh()->locked);
    }

}
