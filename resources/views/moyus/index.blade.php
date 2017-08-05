@extends('layouts.app')
@section('title', 'moyus')

@section('content')
<div class="container">
    <div class="row">
        @foreach($moyus as $moyu)
          @include('moyus.moyu')
        @endforeach
    </div>
</div>
@endsection
