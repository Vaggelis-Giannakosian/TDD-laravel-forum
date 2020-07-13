<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class ReadThreadsTest extends TestCase
{

    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->thread = factory(Thread::class)->create();
    }

    public function test_a_user_can_browse_threads()
    {
        $response = $this->get('/threads');

        $response->assertStatus(200);
        $response->assertSee($this->thread->title);
    }

    public function test_a_user_can_read_a_single_thread()
    {
        $response = $this->get($this->thread->path());

        $response->assertStatus(200);
        $response->assertSee($this->thread->title);
    }

    function test_a_user_can_read_replies_that_are_associated_with_a_thread()
    {
        $reply = factory(Reply::class)->create(['thread_id'=>$this->thread->id]);

        $response = $this->get($this->thread->path());

        $response->assertStatus(200);
        $response->assertSee($reply->body);
    }
}
