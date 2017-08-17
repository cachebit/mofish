@extends('layouts.app')
@section('title', $moyu->title)

@section('content')
<moyu-view :initial-replies-count="{{ $moyu->replies_count }}" inline-template>
<div class="container">
    <div class="row">
        <div class="col-md-8">
          <div class="panel panel-default">
            <div class="panel-heading">
              <ul class="list-inline">
                <li>
                  <a href="/profiles/{{ $moyu->creator->name }}">{{ $moyu->creator->name }}</a> posted:
                  {{ $moyu->title }}
                </li>
                @can('update', $moyu)
                <li class="pull-right">
                  <form action="{{ $moyu->path() }}" method="post">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}

                    <button class="btn btn-xs btn-link" type="submit" name="button">X</button>
                  </form>
                </li>
                @endcan
              </ul>
            </div>
            <div class="panel-body">
              <img src="{{ $moyu->img }}" class="img-responsive" alt="">
            </div>
          </div>

          <replies :data="{{ $moyu->replies }}"
            @added="repliesCount++"
            @removed="repliesCount--"></replies>

            <!-- {{ $replies->links() }} -->
        </div>

        <div class="col-md-4">
          <div class="panel panel-default">
            <div class="panel-body">
              <p>
                This Moyu is published at {{ $moyu->created_at->diffForHumans() }}
                by <a href="#">{{ $moyu->creator->name }}</a>, and currently has
                <span v-text="repliesCount"></span> {{ str_plural('reply', $moyu->replies_count) }}.
              </p>
            </div>
          </div>
        </div>
    </div>
</div>
</moyu-view>
@endsection
