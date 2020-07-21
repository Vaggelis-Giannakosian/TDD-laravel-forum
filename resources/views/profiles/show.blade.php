@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="modal-header mb-4">
                    <h1>
                        {{ $profileUser->name }}
                        <small>Since {{ $profileUser->created_at->diffForHumans() }}</small>
                    </h1>
                </div>

                @foreach($activities as $date => $activity)

                    <h3 class="card-header">
                        {{ $date }}
                    </h3>

                    @foreach($activity as $record)
                        @if(view()->exists("profiles.activities.{$record->type}"))
                            @include("profiles.activities.{$record->type}")
                        @endif
                    @endforeach

                @endforeach

                <div class="d-flex justify-content-center mt-4">
                    {{--                    {{ $activities->links() }}--}}
                </div>
            </div>
        </div>
    </div>
@endsection
