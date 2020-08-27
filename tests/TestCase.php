<?php

namespace Tests;

use App\Channel;
use App\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\View;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    protected function signIn($user = null)
    {
        $user = $user ?: create(User::class,['email_verified_at'=>now()]);
        $this->be($user);
        return $user;
    }

}
