<?php

namespace Tests\Feature;

use App\Activity;
use App\Channel;
use App\Reply;
use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateThreadsTest extends TestCase
{

    use RefreshDatabase;
    
    function test_unauth_user_cannot_update_threads(){

        $this->withExceptionHandling();
        $thread = create(Thread::class);
        $this->patch($thread->path(),[])->assertStatus(302);

        $this->signIn();

        $this->patch($thread->path(),[])->assertStatus(403);
    }

    function test_a_thread_requires_body_and_title_to_be_updated(){
        $this->withExceptionHandling();

        $this->signIn();
        $thread = create(Thread::class,['user_id'=>auth()->id()]);

        $this->patch($thread->path(),[
            'title' => 'new title',
        ])->assertSessionHasErrors('body');

        $this->patch($thread->path(),[
            'body' => 'new body',
        ])->assertSessionHasErrors('title');
    }

    function test_an_auth_user_can_update_their_threads()
    {
        $this->signIn();
        $thread = create(Thread::class,['title'=>'old_title','user_id'=>auth()->id()]);

        $this->patchJson($thread->path(),[
            'title' => 'new title',
            'body' => 'new body'
        ]);

        tap($thread->fresh(),function($thread){
            $this->assertEquals('new title',$thread->title);
            $this->assertEquals('new body',$thread->body);
        });
    }

}
