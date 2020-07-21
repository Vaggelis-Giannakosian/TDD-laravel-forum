<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Reply;
use App\Thread;
use Illuminate\Http\Request;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param Channel $channel
     * @param Thread $thread
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Channel $channel, Thread $thread)
    {

        $this->validate(request(),[
            'body' => 'required',
        ]);


        $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id()
        ]);

        return back()
            ->withFlash('Your reply has been left');
    }
}
