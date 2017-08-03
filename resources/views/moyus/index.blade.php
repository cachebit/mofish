@extends('layouts.app')
@section('title', 'moyus')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
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
                          <h4>{{ $moyu->title }}</h4>
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
            </div>
          </div>

        </div>
    </div>
</div>
@endsection
