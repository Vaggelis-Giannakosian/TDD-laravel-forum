
<x-activity >

    <x-slot name="heading">
        <a href="{{ $profileUser->path() }}">{{ $profileUser->name }}</a> replied to thread:
        <a href="{{ $record->subject->thread->path() }}">{{ $record->subject->thread->title  }}</a>
    </x-slot>

    <x-slot name="created_at">
        {{ $record->subject->created_at->diffForHumans() }}
    </x-slot>

    <x-slot name="body">
        {{ $record->subject->body }}
    </x-slot>

</x-activity>
