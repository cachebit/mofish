@extends('layouts.app')
@section('title', 'Profile')

@section('content')
<div class="container">
  <div class="page-header">
    <h1>
      {{ $profileUser->name }}
      <small>Since {{ $profileUser->created_at->diffForHumans() }}</small>
    </h1>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h3>Moyus</h3>
    </div>
    <div class="panel-body">
      @foreach($moyus as $moyu)
      <div class="row">
          <div class="col-sm-2">
              <a href="{{ $moyu->path() }}">
                <img src="{{ $moyu->thumbnail }}" class="img-responsive" alt="">
              </a>
          </div>
          <div class="col-sm-10">
            <ul class="list-inline">
              <li>
                <a href="{{ $moyu->path() }}">
                  <h4>
                    {{ $moyu->title }}
                    <small> Posted {{ $moyu->created_at->diffForHumans() }} By
                      <a href="/profiles{{ $moyu->creator->name }}">{{ $moyu->creator->name }}</a>
                    </small>
                  </h4>
                </a>
              </li>
              <li class="pull-right">
                <a href="{{ $moyu->path() }}">{{ $moyu->replies_count }} {{ str_plural('reply', $moyu->replies_count) }}</a>
              </li>
            </ul>

          </div>
      </div>
      <hr>
      @endforeach
      {{ $moyus->links() }}
    </div>
  </div>
</div>

@endsection
