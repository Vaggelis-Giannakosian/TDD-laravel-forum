<?php

namespace Tests\Unit;

use App\Reply;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class ReplyTest extends TestCase
{

    use RefreshDatabase;

    function test_reply_has_an_owner()
    {
        $reply = create(Reply::class);

        $this->assertInstanceOf(User::class,$reply->owner);
    }

    function test_a_reply_knows_if_wasJustPublished()
    {
        $reply = create(Reply::class);
        $reply2 = create(Reply::class,[
            'created_at' => now()->subMinute()
        ]);

        $this->assertTrue($reply->wasJustPublished());

        $this->assertFalse($reply2->wasJustPublished());
    }

}
