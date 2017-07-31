@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3>{{ $moyu->title }}</h3>
            </div>
            <div class="panel-body">
              <img src="{{ $moyu->img }}" class="img-responsive" alt="">
            </div>

            <div class="panel-body">
              @foreach($moyu->replies as $reply)
              <div class="panel panel-default">
                <div class="panel-body">
                  {{ $reply->body }}
                </div>
                <div class="panel-footer">
                  <a href="#">
                    {{ $reply->owner->name }}
                  </a> said {{ $reply->created_at->diffForHumans() }}...
                </div>
              </div>
              @endforeach
            </div>

          </div>
        </div>
    </div>
</div>
@endsection
