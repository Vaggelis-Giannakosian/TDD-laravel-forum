@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                @forelse($threads as $thread)
                    <div class="card mb-4">
                        <div class="card-header">
                            <div class="level">
                                <h4 class="flex">
                                    <a href="{{ $thread->path(auth()->user()) }}">
                                        @if($thread->hasUpdatesFor())
                                            <strong>{{ $thread->title }}</strong>
                                        @else
                                            {{ $thread->title }}
                                        @endif
                                    </a>
                                </h4>
                                <a href="{{ $thread->path() }}">
                                    <strong>{{ $thread->replies_count }} {{ \Str::plural('reply',$thread->replies_count) }}</strong>
                                </a>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="body">
                                {{ $thread->body }}
                            </div>
                        </div>
                    </div>

                @empty

                    <p>
                       There are no relevant results at this time
                    </p>

                @endforelse

            </div>
        </div>
    </div>
@endsection
