<?php

namespace Tests\Feature;


use App\Reply;
use App\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use \Illuminate\Foundation\Testing\RefreshDatabase;

class AddAvatarTest extends TestCase
{

    use RefreshDatabase;

    public function test_only_members_can_add_avatars()
    {
        $this->withoutExceptionHandling();
        $user = create(User::class);

        $this->expectException('Illuminate\Auth\AuthenticationException');

        $this->post(route('api.userAvatar.store',$user));
    }


    function test_a_valid_avatar_must_be_provided()
    {
        $user = $this->withExceptionHandling()->signIn();

        $this->post(route('api.userAvatar.store',$user),[
            'avatar' => 'not-an-image'
        ])->assertStatus(302);
    }

    function test_a_user_may_add_an_avatar_to_their_profile()
    {
        $this->signIn();

        Storage::fake('public');

        $this->post(route('api.userAvatar.store',auth()->user()),[
            'avatar' => $file = UploadedFile::fake()->image('avatar.jpg')
        ]);


        $this->assertEquals(asset('avatars/'.$file->hashName()),auth()->user()->avatar_path);

        Storage::disk('public')->assertExists('avatars/'.$file->hashName());
    }

}
