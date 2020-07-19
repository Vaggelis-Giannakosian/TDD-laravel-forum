@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="modal-header">
            <h1>
                {{ $profileUser->name }}
                <small>Since {{ $profileUser->created_at->diffForHumans() }}</small>
            </h1>
        </div>

        <br>

        @foreach($threads as $thread)
            <div class="card">
                <div class="card-header">
                    <div class="level">
                        <span class="flex">
                            <a href="{{ $thread->creator->path() }}">{{ $thread->creator->name }}</a> posted:
                            {{ $thread->title }}
                        </span>

                        <span>
                            {{$thread->created_at->diffForHumans()}}
                        </span>
                    </div>

                </div>
                <div class="card-body">
                    {{ $thread->body }}
                </div>
            </div>
        @endforeach

        <div class="d-flex justify-content-center mt-4">
            {{ $threads->links() }}
        </div>



    </div>
@endsection
