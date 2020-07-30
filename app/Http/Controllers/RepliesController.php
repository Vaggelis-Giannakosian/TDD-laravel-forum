<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Reply;
use App\Thread;
use App\Inspections\Spam;
use Illuminate\Http\Request;

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
    public function store(Channel $channel, Thread $thread)
    {
        try{
        $this->validateReply();


        $reply = $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id()
        ]);
        }catch (\Exception $e){
            return response('Sorry your reply could not be saved at this time.',422);
        }



        if(request()->expectsJson())
        {
            return $reply->load('owner');
        }


        return back()->withFlash('Your reply has been left');
    }

    public function update(Reply $reply){
        $this->authorize($reply);

        try{
            $this->validateReply();
            $reply->update(request(['body']));
        }catch (\Exception $e){
            return response('Sorry your reply could not be saved at this time.',422);
        }

    }

    public function destroy(Reply $reply)
    {
        $this->authorize($reply);

        $reply->delete();

        if(request()->expectsJson())
        {
            return response([
                'status' => 'Reply deleted'
            ]);
        }


        return back()->withFlash('You reply was deleted');
    }

    /**
     * @param Spam $spam
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateReply(): void
    {
        $this->validate(request(), [
            'body' => 'required',
        ]);

        resolve(Spam::class)->detect(request('body'));
    }
}
