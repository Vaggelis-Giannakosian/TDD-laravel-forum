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
        View::share('channels', Channel::all());
    }

    protected function signIn($user = null)
    {
        $user = $user ?: create(User::class);
        $this->be($user);
        return $user;
    }

}
