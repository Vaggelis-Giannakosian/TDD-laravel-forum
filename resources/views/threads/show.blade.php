@extends('layouts.app')

@section('content')

    <thread-view :initial-replies-count="{{ $thread->replies_count }}" inline-template>
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <div class="level">
                            <span class="flex">
                                  <a href="{{  $thread->creator->path() }}">
                            {{ $thread->creator->name }}
                        </a>
                        posted
                        {{ $thread->title }}
                            </span>

                                @can('delete',$thread)
                                    <span>
                                    <form method="POST" action="{{ $thread->path()}}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link">
                                            Delete Thread
                                        </button>
                                    </form>
                                </span>
                                @endcan
                            </div>

                        </div>
                        <div class="card-body">
                            {{ $thread->body }}
                        </div>
                    </div>

                    <br>

                    <replies @added="repliesCount++" @removed="repliesCount--"></replies>

                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            This thread was published {{ $thread->created_at->diffForHumans() }} by
                            <a href="">{{ $thread->creator->name }}</a>, and currently
                            has <span v-text="repliesCount"></span> {{ \Str::plural('comment',$thread->replies_count) }}.
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </thread-view>

@endsection
