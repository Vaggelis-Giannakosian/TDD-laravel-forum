
@component('components.activity')

    @slot('heading')
        <a href="{{ $profileUser->path() }}">{{ $profileUser->name }}</a> favorited a <a href="{{ $record->subject->favorable->path() }}">reply</a>
    @endslot

    @slot('created_at')
        {{$record->subject->created_at->diffForHumans()}}
    @endslot

    <x-slot name="body">
        {{ $record->subject->favorable->body }}
    </x-slot>
@endcomponent
