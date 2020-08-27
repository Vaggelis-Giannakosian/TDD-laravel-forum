<?php

namespace Tests\Feature;



use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use \Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationTest extends TestCase
{

    use RefreshDatabase;

    public function test_a_confirmation_email_is_sent_on_email_registration()
    {
        Notification::fake();

        $user = create(User::class);
        event(new Registered($user));

        $this->assertEquals(['mail'], (new VerifyEmail)->via($user));
        Notification::assertSentTo($user,VerifyEmail::class);
    }



}
