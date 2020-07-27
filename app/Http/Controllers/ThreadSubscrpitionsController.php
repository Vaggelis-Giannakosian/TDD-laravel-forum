<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Http\Controllers\Controller;
use App\Thread;
use Illuminate\Http\Request;

class ThreadSubscrpitionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store($channelId, Thread $thread)
    {
        $thread->subscribe();

        if(request()->expectsJson())
        {
            return response(['status'=>'Subscription created']);
        }

        return back();
    }

    public function destroy($channelId, Thread $thread)
    {
        $thread->unsubscribe();

        if(request()->expectsJson())
        {
            return response(['status'=>'Subscription deleted']);
        }

        return back();
    }
}
