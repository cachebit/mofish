@extends('layouts.app')
@section('title', 'create a moyu')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3>Create a Moyu</h3>
            </div>
            <div class="panel-body">
              <form class="" action="/moyus" method="post">
                {{ csrf_field() }}

                <div class="form-group">
                  <label for="channel_id">Choose a Channel:</label>
                  <select class="form-control" name="channel_id" value="{{ old('title') }}" required>
                    <option value="">Choose one...</option>
                      @foreach(App\Channel::all() as $channel)
                        <option value="{{ $channel->id }}" {{ old('channel_id') == $channel->id? 'selected':'' }}>
                          {{ $channel->name }}
                        </option>
                      @endforeach
                  </select>
                </div>

                <div class="form-group">
                  <label for="title">Title:</label>
                  <input class="form-control" type="text" name="title" value="{{ old('title') }}" required>
                </div>

                <div class="form-group">
                  <label for="img">Img:</label>
                  <input class="form-control" type="text" name="img" value="/site/default.png" required>
                </div>

                <div class="form-group">
                  <label for="thumbnail">Thumbnail:</label>
                  <input class="form-control" type="text" name="thumbnail" value="/site/thumbnail.png" required>
                </div>

                <div class="form-group">
                  <button class="btn btn-default" type="submit" name="button">Publish</button>
                </div>

                @if(count($errors))
                  <ul class="alert alert-danger">
                    @foreach($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                @endif
              </form>

            </div>
          </div>

        </div>
    </div>
</div>
@endsection
