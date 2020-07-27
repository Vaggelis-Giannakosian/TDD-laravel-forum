<?php

namespace Tests\Feature;


use App\Thread;
use Tests\TestCase;
use \Illuminate\Foundation\Testing\RefreshDatabase;


class SubscribeToThreadsTest extends TestCase
{

    use RefreshDatabase;

    public function test_a_user_can_subscribe_to_threads()
    {
        $this->signIn();

        //given we have a thread
        $thread = create(Thread::class);

        //and the user subscribes to the thread
        $this->post($thread->path() . '/subscriptions');
        $this->assertCount(1, $thread->subscriptions);
    }

    public function test_a_user_can_unsubscribe_from_threads()
    {
        $this->signIn();

        //given we have a thread
        $thread = create(Thread::class);

        //and the user subscribes to the thread
        $this->post($thread->path() . '/subscriptions');
        $this->assertCount(1, $thread->subscriptions);

        $this->delete($thread->path() . '/subscriptions');

        $this->assertCount(0, $thread->fresh()->subscriptions);
    }


}
