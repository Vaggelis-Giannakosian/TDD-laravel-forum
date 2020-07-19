<?php


namespace Tests\Feature;


use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfilesTest extends TestCase
{

    use RefreshDatabase;


    public function test_a_user_has_a_profile()
    {
        $user = create(User::class);
        $this->get(route('user.profile',$user))->assertSee($user->name);
    }

    public function test_a_user_profile_has_his_threads()
    {
        $user = create(User::class);
        $userThread = create(Thread::class,['user_id'=>$user->id]);
        $foreignThread = create(Thread::class);

        $this->get(route('user.profile',$user))
            ->assertSee($userThread->title)
            ->assertSee($userThread->body)
            ->assertDontSee($foreignThread->title);
    }

}
