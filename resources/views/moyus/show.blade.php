@extends('layouts.app')
@section('title', $moyu->title)

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
          <div class="panel panel-default">
            <div class="panel-heading">
              <a href="#">{{ $moyu->creator->name }}</a> posted:
              {{ $moyu->title }}
            </div>
            <div class="panel-body">
              <img src="{{ $moyu->img }}" class="img-responsive" alt="">
            </div>


            <div class="panel-default">
              <div class="panel-body">
                @if(auth()->check())
                <form class="" action="{{ $moyu->path().'/replies' }}" method="post">
                  {{ csrf_field() }}

                  <div class="form-group">
                    <textarea class="form-control" name="body" rows="8" cols="80" placeholder="Post a reply!"></textarea>
                  </div>

                  <button class="btn btn-default" type="submit" name="button">Post</button>
                </form>
                @else
                <p class="text-center">To participate the moyu! Please <a href="{{ route('login') }}">Login</a>!</p>
                @endif
              </div>
            </div>


            <div class="panel-body">
              @foreach($moyu->replies as $reply)
              @include('moyus.reply')
              @endforeach
            </div>

          </div>
        </div>
    </div>
</div>
@endsection
