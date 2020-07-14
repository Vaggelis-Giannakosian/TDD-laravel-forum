<?php

namespace Tests\Unit;


use App\Channel;
use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThreadsTest extends TestCase
{
    use RefreshDatabase;

    protected $thread;
    protected $reply;

    public function setUp(): void
    {
        parent::setUp();
        $this->thread = create(Thread::class);
    }

    public function test_a_thread_has_valid_string_path()
    {
        $thread = make(Thread::class);
        $this->assertEquals("/threads/{$thread->channel->slug}/{$thread->id}",$thread->path());
    }

    public function test_a_thread_has_replies()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection',$this->thread->replies);
    }

    public function test_a_thread_has_a_creator()
    {
        $this->assertInstanceOf(User::class,$this->thread->creator);
    }

    public function test_a_thread_can_add_a_reply()
    {
        $this->thread->addReply([
            'body' => 'foobar',
            'user_id' => 1
        ]);

        $this->assertCount(1,$this->thread->replies);
    }

    function test_a_thread_belongs_to_a_channel()
    {
        $this->assertInstanceOf(Channel::class,$this->thread->channel);
    }

}
