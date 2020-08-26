<?php

namespace Tests\Feature;


use App\Reply;
use App\Thread;
use App\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;

use Tests\TestCase;
use \Illuminate\Foundation\Testing\RefreshDatabase;

class TrendingThreadsTest extends TestCase
{

    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Redis::del('trending_threads');
    }

    public function test_it_increments_a_threads_score_each_time_it_is_read()
    {
        $this->assertEmpty(Redis::zrevrange('trending_threads',0,-1));

        $thread = create(Thread::class);

        $this->get(route('threads.show',[$thread->channel,$thread]));

        $trending = Redis::zrevrange('trending_threads',0,-1);

        $this->assertCount(1,$trending);

        $this->assertEquals($thread->title,json_decode($trending[0])->title);
    }


}
