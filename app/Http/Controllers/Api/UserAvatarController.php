<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class UserAvatarController extends Controller
{

    public function store()
    {

        request()->validate([
            'avatar' => 'required|image'
        ]);

        auth()->user()->update([
            'avatar_path' =>request()->file('avatar')->store('avatars','public')
        ]);

        if(request()->expectsJson())
        {
            return response([],204);
        }

        return back();

    }
}
