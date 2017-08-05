@extends('layouts.app')
@section('title', 'Profile')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">

      <div class="page-header">
        <h1>
          {{ $profileUser->name }}
          <small>Since {{ $profileUser->created_at->diffForHumans() }}</small>
        </h1>
      </div>

      <div class="row">
        @forelse($moyus as $moyu)
          @include('moyus.moyu')
        @empty
          <p>No Result Now.</p>
        @endforelse
        {{ $moyus->links() }}
      </div>

    </div>
  </div>
</div>

@endsection
