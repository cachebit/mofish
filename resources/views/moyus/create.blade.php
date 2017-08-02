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
                  <label for="title">Title:</label>
                  <input class="form-control" type="text" name="title" value="">
                </div>

                <div class="form-group">
                  <label for="img">Img:</label>
                  <input class="form-control" type="text" name="img" value="/site/default.png" disabled>
                </div>

                <div class="form-group">
                  <label for="thumbnail">Thumbnail:</label>
                  <input class="form-control" type="text" name="thumbnail" value="/site/thumbnail.png" disabled>
                </div>

                <button class="btn btn-default" type="submit" name="button">Publish</button>
              </form>
            </div>
          </div>

        </div>
    </div>
</div>
@endsection
