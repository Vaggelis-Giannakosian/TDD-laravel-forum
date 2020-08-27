<?php

namespace Tests\Feature;


use App\Reply;
use App\Thread;
use App\Trending;
use App\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;

use Tests\TestCase;
use \Illuminate\Foundation\Testing\RefreshDatabase;

class TrendingThreadsTest extends TestCase
{

    use RefreshDatabase;

    protected $trending;

    public function setUp(): void
    {
        parent::setUp();
        $this->trending = new Trending();
        $this->trending->reset();
    }

    public function test_it_increments_a_threads_score_each_time_it_is_read( )
    {
        $this->assertEmpty( $this->trending->get());
        $thread = create(Thread::class);

        $this->get(route('threads.show',[$thread->channel,$thread]));

        $this->assertCount(1, $trending = $this->trending->get());
        $this->assertEquals($thread->title, $trending[0]->title);
    }


}
