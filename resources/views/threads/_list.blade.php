@forelse($threads as $thread)
    <div class="card mb-4">
        <div class="card-header">
            <div class="level">
                <div class="flex">
                    <h4 class="">
                        <a href="{{ $thread->path(auth()->user()) }}">
                            @if(auth()->check() && $thread->hasUpdatesFor())
                                <strong>{{ $thread->title }}</strong>
                            @else
                                {{ $thread->title }}
                            @endif
                        </a>
                    </h4>
                    <h5>
                        Posted by: <a href="{{ route('user.profile',$thread->creator) }}">{{ $thread->creator->name }}</a>
                    </h5>
                </div>

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
        <div class="card-footer">
           {{ $thread->visits() }} Visits
        </div>
    </div>

@empty

    <p>
        There are no relevant results at this time
    </p>

@endforelse
