@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/vendor/jquery.atwho.css') }}">
@endsection

@section('content')

    <thread-view  :data-locked="{{$thread->locked}}" :data-replies-count="{{ $thread->replies_count }}" inline-template>
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <div class="level">

                                <img src="{{ $thread->creator->avatar()}}" alt="" width="50" height="50" class="mr-2 rounded-lg">
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
                            <p>
                                This thread was published {{ $thread->created_at->diffForHumans() }} by
                                <a href="">{{ $thread->creator->name }}</a>, and currently
                                has <span
                                    v-text="repliesCount"></span> {{ \Str::plural('comment',$thread->replies_count) }}.
                            </p>

                            <p>
                                <subscribe-button v-if="signedIn" :active="{{ json_encode($thread->isSubscribedTo)}}"></subscribe-button>

                                <button v-if="authorize('isAdmin') && !locked" class="btn btn-outline-secondary" @click="locked=true">Lock</button>

                                <button v-if="authorize('isAdmin') && locked" class="btn btn-outline-secondary" @click="locked=false">Unlock</button>
                            </p>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </thread-view>

@endsection
