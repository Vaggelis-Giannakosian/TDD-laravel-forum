<?php

namespace Tests\Feature;

use App\Channel;
use App\Reply;
use App\Thread;
use App\User;
use http\Env\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class ReadThreadsTest extends TestCase
{

    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->thread = create(Thread::class);
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

    function test_a_user_can_filter_threads_according_to_a_channel()
    {
        $channel = create(Channel::class);
        $threadInChannel = create(Thread::class,['channel_id'=>$channel->id]);
        $threadNotInChannel = create(Thread::class);

        $this->get('/threads/'.$channel->slug)->assertSee($threadInChannel->title)->assertDontSee($threadNotInChannel->title);
    }

    function test_a_user_can_filter_threads_by_any_username()
    {
        $john = create(User::class,['name'=>'John']);
        $threadByJohn = create(Thread::class,['user_id'=>$john->id]);
        $threadNotByJohn = create(Thread::class);

        $this->get('/threads?by=John')
            ->assertSee($threadByJohn->title)
            ->assertDontSee($threadNotByJohn->title);

    }

    function test_a_user_can_filter_threads_by_popularity()
    {
        //order threads according to replies count
        $threadWithTwoReplies = create(Thread::class);
        create(Reply::class,['thread_id'=>$threadWithTwoReplies->id],2);

        $threadWithThreeReplies = create(Thread::class);
        create(Reply::class,['thread_id'=>$threadWithThreeReplies->id],3);

        $threadWithNoReplies = $this->thread;

        $response = $this->getJson('/threads?popular=1')->json();

        $this->assertEquals([3,2,0],array_column($response['data'],'replies_count'));

    }

    function test_a_user_can_filter_unanswered_threads()
    {
        $thread = create(Thread::class);
        create(Reply::class,['thread_id'=>$thread->id]);

        $response = $this->getJson('/threads?unanswered=1')
            ->assertSee($this->thread->title)
            ->assertDontSee($thread->title)
            ->json();

        $this->assertCount(1,$response['data']);
    }

    function test_a_user_can_request_all_replies_for_a_given_thread()
    {
        $thread = create(Thread::class);
        create(Reply::class,['thread_id'=>$thread->id],2);

        $response = $this->getJson($thread->path().'/replies')->json();

        $this->assertCount(2,$response['data']);
        $this->assertEquals(2,$response['total']);
    }

}
