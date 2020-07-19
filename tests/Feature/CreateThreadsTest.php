<?php

namespace Tests\Feature;

use App\Channel;
use App\Reply;
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
        $this->withExceptionHandling();

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
        $response = $this->post('/threads',$thread->toArray());


        //Then we visit the thread page and We should see the new thread
        $this->get($response->headers->get('Location'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    public function test_a_thread_requires_a_title()
    {
        $this->publishThread(['title'=>null])->assertSessionHasErrors('title');
    }

    public function test_a_thread_requires_a_body()
    {
        $this->publishThread(['body'=>null])->assertSessionHasErrors('body');
    }

    public function test_a_thread_requires_a_valid_channel()
    {
        factory(Channel::class,2)->create();

        $this->publishThread(['channel_id'=>null])->assertSessionHasErrors('channel_id');
        $this->publishThread(['channel_id'=>999])->assertSessionHasErrors('channel_id');
    }

    public function test_unauthorized_users_cannot_delete_threads()
    {
        $this->withExceptionHandling();
        $thread = create(Thread::class);

        $this->delete($thread->path())->assertRedirect('/login');

        $this->signIn();

        $this->delete($thread->path())->assertStatus(403);
        $this->assertDatabaseHas('threads',$thread->only(['title','id','body','user_id']));
    }


    public function test_authorized_users_can_delete_threads()
    {
        $this->signIn();
        $thread = create(Thread::class,['user_id'=>auth()->id()]);
        $reply = create(Reply::class,['thread_id'=>$thread->id]);

        $response = $this->json('DELETE',$thread->path());

        $response->assertStatus(204);
        $this->assertDatabaseMissing('threads',$thread->only(['title','id','body','user_id']));
        $this->assertDatabaseMissing('replies',$reply->only(['id','body']));
    }

    protected function publishThread(array $ovverides = [])
    {
        $this->signIn();
        $this->withExceptionHandling();
        $thread = make(Thread::class,$ovverides);
        return $this->post('/threads',$thread->toArray());
    }

}
