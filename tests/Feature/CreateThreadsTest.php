<?php

namespace Tests\Feature;

use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{

    use RefreshDatabase;

    public function test_guests_may_not_create_new_forum_threads()
    {

        $this->get(route('threads.create'))
            ->assertRedirect(route('login'));

        $this->post(route('threads.store'))
            ->assertRedirect(route('login'));
    }


    public function test_an_auth_user_can_create_new_forum_threads()
    {

        //given a signed in user
        $this->signIn($user = create(User::class));
        $thread = create(Thread::class);


        //when we hit the endpoint to create a new thread
        $postRequest = $this->post('/threads',$thread->toArray());

        //Then we visit the thread page and We should see the new thread
        $this->get(route('threads.show',[$thread->channel,$thread]))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }





}
