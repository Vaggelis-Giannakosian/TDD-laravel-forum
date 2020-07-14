<?php

namespace Tests\Unit;

use App\Channel;
use App\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChannelTest extends TestCase
{
    use RefreshDatabase;

    public function test_channel_has_threads()
    {
        $channel = create(Channel::class);
        $thread = create(Thread::class,['channel_id'=>$channel->id]);

        $this->assertTrue($channel->threads->contains($thread));
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection',$channel->threads);
    }
}

