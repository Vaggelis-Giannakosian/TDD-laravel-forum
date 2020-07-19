<?php

namespace Tests\Feature;


use App\Reply;
use Tests\TestCase;
use \Illuminate\Foundation\Testing\RefreshDatabase;

class FavoritesTest extends TestCase
{

    use RefreshDatabase;

    public function test_guests_cannot_favorite_a_reply()
    {
        $this->withExceptionHandling();

        $reply = create(Reply::class);
        $this->post(route('reply.favorite',$reply))->assertRedirect(route('login'));
    }

    public function test_an_auth_user_can_favorite_any_reply()
    {
        $this->signIn();
        $reply = create(Reply::class);


        $this->post(route('reply.favorite',$reply));

        $this->assertCount(1,$reply->favorites);
        $this->assertDatabaseHas('favorites',['favorable_id'=>$reply->id,'favorable_type'=>Reply::class]);
    }

    public function test_an_auth_may_only_favorite_a_reply_once()
    {
        $this->signIn();
        $reply = create(Reply::class);

        $this->post(route('reply.favorite',$reply));
        $this->post(route('reply.favorite',$reply));

        $this->assertCount(1,$reply->favorites);
    }

}
