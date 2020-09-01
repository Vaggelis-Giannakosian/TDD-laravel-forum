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

    public function test_admin_can_lock_any_thread()
    {
        $this->signIn();

        $thread = create(Thread::class);

        $thread->lock();

        $this->postJson($thread->path().'/replies',[
            'body'=>'Foobar',
            'user_id'=>create(User::class)->id
        ])->assertStatus(422);

    }

}
