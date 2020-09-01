<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Http\Requests\CreatePostRequest;
use App\Reply;
use App\Rules\SpamFree;
use App\Thread;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index']);
    }

    public function index(Channel $channel, Thread $thread)
    {
        return $thread->replies()->paginate(5);
    }

    /**
     * @param Channel $channel
     * @param Thread $thread
     */
    public function store(Channel $channel, Thread $thread, CreatePostRequest $form)
    {
        if($thread->locked)
        {
            return response('Thread is locked',422);
        }

        $reply = $form->persist($thread);

        if (request()->expectsJson()) {
            return $reply->load('owner');
        }

        return back()->withFlash('Your reply has been left');
    }

    public function update(Reply $reply)
    {
        $this->authorize($reply);

        request()->validate([
            'body' => ['required', new SpamFree],
        ]);

        $reply->update(request(['body']));
    }

    public function destroy(Reply $reply)
    {
        $this->authorize($reply);

        $reply->delete();

        if (request()->expectsJson()) {
            return response([
                'status' => 'Reply deleted'
            ]);
        }


        return back()->withFlash('You reply was deleted');
    }

}
