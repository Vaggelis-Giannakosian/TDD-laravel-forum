@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="modal-header mb-4 flex-wrap">
                    <h1>
                        {{ $profileUser->name }}
                        <small>Since {{ $profileUser->created_at->diffForHumans() }}</small>
                    </h1>

                    @can('update',$profileUser)
                        <form enctype="multipart/form-data" method="POST" action="{{ route('api.userAvatar.store',$profileUser) }}" class="flex-grow-1">
                            @csrf
                            <div class="form-group ">
                               <label for="avatar" class="font-weight-bold">Avatar:</label>
                               <input type="file" name="avatar" accept="images/*" id="avatar" class="form-control w-auto" placeholder="Avatar">
                            </div>

                            <button type="submit" class="btn btn-primary">Add Avatar</button>
                        </form>
                    @endcan

                    <img src="{{ $profileUser->avatar() }}" alt="" width="200">

                </div>

                @forelse($activities as $date => $activity)

                    <h3 class="card-header">
                        {{ $date }}
                    </h3>

                    @foreach($activity as $record)
                        @if(view()->exists("profiles.activities.{$record->type}"))
                            @include("profiles.activities.{$record->type}")
                        @endif
                    @endforeach

                @empty
                    <p>
                        There is no activity for this user yet
                    </p>
                @endforelse

                <div class="d-flex justify-content-center mt-4">
                    {{--                    {{ $activities->links() }}--}}
                </div>
            </div>
        </div>
    </div>
@endsection
