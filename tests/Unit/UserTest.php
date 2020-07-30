<?php

namespace Tests\Unit;


use App\Activity;
use App\Reply;
use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_user_can_access_their_latest_reply()
    {
        $user = create(User::class);
        create(Reply::class,['user_id'=>$user->id,'created_at'=>now()->subDay()]);
        $reply = create(Reply::class,['user_id'=>$user->id]);
        $userLatestReply = $user->lastReply;

        $this->assertInstanceOf(Reply::class, $userLatestReply);
        $this->assertTrue($userLatestReply->is($reply));
    }



}
