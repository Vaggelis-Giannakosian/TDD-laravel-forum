@extends('layouts.app')

@section('content')
    <div class="container">


        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a href="#">
                            {{ $thread->creator->name }}
                        </a>
                        posted
                        {{ $thread->title }}
                    </div>
                    <div class="card-body">
                        {{ $thread->body }}
                    </div>
                </div>

                <br>

                @foreach($replies as $reply)
                    @include('threads.reply')
                @endforeach

                {{ $replies->links() }}

                @auth
                    <form method="POST" action="{{ route('replies.store',[$thread->channel,$thread] ) }}">
                        @csrf
                        <div class="form-group">
                            <label class="font-weight-bold" for="body">Post your reply here!</label>
                            <textarea placeholder="Have something to say?" name="body" rows="3" id="body"
                                      class="form-control"></textarea>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Post</button>
                        </div>
                    </form>
                @else
                    <p class="text-center">Please <a href="{{ route('login') }}">sign in</a> to participate in this discussion
                    </p>
                @endauth

            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                       This thread was published {{ $thread->created_at->diffForHumans() }} by
                        <a href="">{{ $thread->creator->name }}</a>, and currently has {{ $thread->replies_count }} {{ \Str::plural('comment',$thread->replies_count) }}.
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
