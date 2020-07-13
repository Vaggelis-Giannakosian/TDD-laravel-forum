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
        $reply = factory(Reply::class)->create();

        $this->assertInstanceOf(User::class,$reply->owner);
    }

}
