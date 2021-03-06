@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create a new Thread</div>

                    <div class="card-body">

                        <form action="{{ route('threads.store') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label for="channel">Channel:</label>
                                <select type="text" name="channel_id" id="channel" class="form-control" required>
                                    <option value="" >Choose Channel</option>
                                    @foreach($channels as $channel)
                                        <option {{ old('channel_id') == $channel->id ? 'selected' : '' }} value="{{ $channel->id }}">{{ $channel->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="title">Title:</label>
                                <input type="text" name="title" id="title" class="form-control" placeholder="title"
                                       value="{{ old('title') }}" required>
                            </div>

                            <div class="form-group">
                                <label for="body">Body:</label>
                                <wysiwyg v-model="form.body" name="body"></wysiwyg>
{{--                                <textarea name="body" id="body" class="form-control" rows="8"--}}
{{--                                          required placeholder="Body">{{ old('body') }}</textarea>--}}
                            </div>


                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Publish</button>
                            </div>


                            @if(count($errors))
                                <ui class="alert alert-danger d-block">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ui>
                            @endif

                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
