@extends('layouts.app')
@section('title', 'moyus')

@section('content')
<div class="container">
    <div class="row">
        @forelse($moyus as $moyu)
          @include('moyus.moyu')
        @empty
          <p>No Result Now.</p>
        @endforelse 
    </div>
</div>
@endsection
