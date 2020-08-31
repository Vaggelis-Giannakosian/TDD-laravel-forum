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

    function test_it_can_detect_all_mentioned_users_in_the_body()
    {
        $reply = create(Reply::class,['body'=>'@JaneDoe wants to talk with @JohnDoe']);

        $this->assertEquals(['JaneDoe','JohnDoe'],$reply->mentionedUsers());
    }

    function test_it_wraps_mentioned_usernames_in_the_body_within_anchor_tags()
    {
        $jane = create(User::class,['name'=>'JaneDoe']);
        $reply = create(Reply::class,['body'=>'Hello @Jane-Doe.']);

        $this->assertEquals(
            'Hello <a href="/profiles/Jane-Doe">@Jane-Doe</a>.',
            $reply->body
        );
    }


    function test_it_knows_if_it_is_the_best_reply()
    {
        $reply = create(Reply::class);

        $this->assertFalse($reply->isBest());

        $reply->thread->update(['best_reply_id'=>$reply->id]);

        $this->assertTrue($reply->fresh()->isBest());
    }

}
