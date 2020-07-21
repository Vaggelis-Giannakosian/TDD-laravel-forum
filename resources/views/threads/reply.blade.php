<div id="reply-{{ $reply->id }}" class="card">

    <div class="card-header">
        <div class="level">
            <h6 class="flex">
                <a href="{{ $reply->owner->path() }}">
                    {{ $reply->owner->name }}
                </a>
                said {{ $reply->created_at->diffForHumans() }}...
            </h6>


            <div>
                <form action="{{ route('reply.favorite',$reply) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-info" {{ $reply->isFavorited() ? 'disabled' : '' }}>
                        {{ $reply->favorites_count }} {{ \Str::plural('Favorite',$reply->favorites_count) }}
                    </button>
                </form>
            </div>
        </div>
    </div>


    <div class="card-body">

        {{ $reply->body }}

    </div>

    @can('delete',$reply)
        <div class="card-footer">
            <form method="POST" action="{{ route('replies.destroy',$reply) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">
                    Delete
                </button>
            </form>
        </div>
    @endcan
</div>
<br>
