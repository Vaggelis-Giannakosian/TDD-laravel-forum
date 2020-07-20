
@component('components.activity')

    @slot('heading')
        <a href="{{ $profileUser->path() }}">{{ $profileUser->name }}</a> published:
        <a href="{{ $record->subject->path() }}">{{ $record->subject->title }}</a>
    @endslot

    @slot('created_at')
        {{$record->subject->created_at->diffForHumans()}}
    @endslot

    @slot('body')
        {{ $record->subject->body }}
    @endslot

@endcomponent
