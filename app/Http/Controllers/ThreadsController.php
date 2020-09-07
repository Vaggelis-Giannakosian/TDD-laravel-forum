<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Filters\ThreadFilters;
use App\Inspections\Spam;
use App\Rules\SpamFree;
use App\Thread;
use App\Trending;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use JavaScript;


class ThreadsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
        $this->middleware('must-be-confirmed')->only(['store']);
    }

    /**
     * @param Channel $channel
     * @param ThreadFilters $filters
     * @param Trending $trending
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function index(Channel $channel, ThreadFilters $filters, Trending $trending)
    {
//        JavaScript::put([
//            'foo' => 'bar',
//            'user' => Thread::first(),
//            'age' => 29
//        ]);

        $threads = $this->getThreads($filters, $channel);

        if (request()->wantsJson()) {
            return $threads;
        }

        return view('threads.index', [
            'threads' => $threads,
            'trending' => $trending->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('threads.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Spam $spam
     * @return
     */
    public function store(Request $request, Spam $spam)
    {

        $request->validate([
            'title' => ['required', new SpamFree],
            'body' => ['required', new SpamFree],
            'channel_id' => 'required|exists:channels,id',
        ]);


        $thread = Thread::create([
            'title' => request('title'),
            'body' => request('body'),
            'channel_id' => request('channel_id'),
            'user_id' => auth()->id(),
        ]);

        if(request()->expectsJson())
        {
            return response($thread,201);
        }

        return redirect($thread->path())
            ->withFlash('Your thread has been published');
    }

    /**
     * Display the specified resource.
     *
     * @param Channel $channel
     * @param \App\Thread $thread
     * @param Trending $trending
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Channel $channel, Thread $thread, Trending $trending)
    {
        //record the timestamp when user visited this page
        if (auth()->check()) {
            auth()->user()->read($thread);
        }

        $thread->visits()->record();

        $trending->push($thread);

        return view('threads.show', compact('thread'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Thread $thread
     * @return \Illuminate\Http\Response
     */
    public function edit(Thread $thread)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Thread $thread
     * @return \Illuminate\Http\Response
     */
    public function update($channel, Thread $thread)
    {
        $this->authorize('update',$thread);

        $data = request()->validate([
            'title' => ['required',new SpamFree],
            'body' => ['required',new SpamFree],
            'channel_id' => 'exists:channels,id',
        ]);
        $thread->update($data);

        if(!request()->expectsJson())
        {
           return redirect($thread->path())
                ->withFlash('Your thread has been updated');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Thread $thread
     */
    public function destroy(Channel $channel, Thread $thread)
    {
        $this->authorize('delete', $thread);


        $thread->delete();

        if (request()->wantsJson()) {
            return response([], 204);
        }

        return redirect()->route('threads.index');
    }

    /**
     * @param ThreadFilters $filters
     * @param Channel $channel
     * @return mixed
     */
    protected function getThreads(ThreadFilters $filters, Channel $channel)
    {
        $threads = Thread::latest()->filter($filters);

        if ($channel->exists) {
            $threads->where('channel_id', $channel->id);
        }

        $threads = $threads->paginate(25);
        return $threads;
    }
}
