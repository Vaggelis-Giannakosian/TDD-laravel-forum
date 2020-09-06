@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/vendor/jquery.atwho.css') }}">
@endsection

@section('content')

    <thread-view  :thread="{{ $thread }}" inline-template>
        <div class="container">
            <div class="row">
                <div class="col-md-8" v-cloak>

                    @include('threads._question')

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

                                <button v-if="authorize('isAdmin')" class="btn btn-outline-secondary" v-text="locked ? 'Unlock' : 'Lock'" @click="toggleLock"></button>

                            </p>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </thread-view>

@endsection
