<?php

namespace Tests\Unit;


use App\Channel;
use App\Notifications\ThreadWasUpdated;
use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use \Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Redis;
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
        $thread = create(Thread::class);
        $this->assertEquals("/threads/{$thread->channel->slug}/{$thread->slug}", $thread->path());
    }

    public function test_a_thread_has_replies()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->thread->replies);
    }

    public function test_a_thread_has_a_creator()
    {
        $this->assertInstanceOf(User::class, $this->thread->creator);
    }

    public function test_a_thread_can_add_a_reply()
    {
        $this->thread->addReply([
            'body' => 'foobar',
            'user_id' => 1
        ]);

        $this->assertCount(1, $this->thread->replies);
    }

    function test_a_thread_belongs_to_a_channel()
    {
        $this->assertInstanceOf(Channel::class, $this->thread->channel);
    }

    function test_a_thread_can_be_subscribed_to()
    {
        $thread = create(Thread::class);

        $userId = 1;
        $thread->subscribe($userId);
        $this->assertEquals(1, $thread->subscriptions()->where('user_id', $userId)->count());

    }

    function test_a_thread_can_be_unsubscribed_from()
    {
        $thread = create(Thread::class);

        $thread->subscribe($userId = 1);
        $thread->unsubscribe($userId);

        $this->assertEquals(0, $thread->subscriptions()->where('user_id', $userId)->count());
    }

    function test_thread_knows_an_auth_user_is_subscribed_to_it()
    {
        $this->signIn();
        $thread = create(Thread::class);

        $this->assertFalse($thread->isSubscribedTo);

        $thread->subscribe();

        $this->assertTrue($thread->isSubscribedTo);
    }

    function test_a_thread_notifies_all_subscribers_when_a_reply_is_added()
    {
        Notification::fake();

        $this->signIn();

        $this->thread
            ->subscribe()
            ->addReply([
                'body' => 'foobar',
                'user_id' => create(User::class)->id
            ]);


        Notification::assertSentTo(auth()->user(), ThreadWasUpdated::class);
    }


    function test_a_thread_can_check_if_auth_user_has_read_all_replies()
    {
        $this->signIn();
        $authUser = auth()->user();

        $this->assertTrue($this->thread->hasUpdatesFor($authUser));

        $this->get($this->thread->path());

        $this->assertFalse($this->thread->hasUpdatesFor($authUser));

        sleep(1);

        $this->thread
            ->addReply([
                'body' => 'foobar',
                'user_id' => create(User::class)->id
            ]);

        $this->assertTrue($this->thread->fresh()->hasUpdatesFor($authUser));
    }

    function test_a_thread_records_each_visit()
    {
        $thread = make(Thread::class, [
            'id' => 10
        ]);

        $visits = $thread->visits();

        $visits->reset();

        $this->assertSame(0,$visits->count());

        $visits->record();

        $this->assertEquals(1,$visits->count());

        $visits->record();

        $this->assertEquals(2,$visits->count());

    }

    function test_a_thread_can_be_locked()
    {
        $this->assertFalse($this->thread->locked);

        $this->thread->lock();

        $this->assertTrue($this->thread->locked);
    }

    function test_a_thread_can_be_unlocked()
    {
        $thread = create(Thread::class,['locked'=>true]);

        $this->assertTrue($thread->locked);

        $thread->unlock();

        $this->assertFalse($thread->locked);
    }

}
