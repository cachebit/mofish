<div class="col-xs-6 col-sm-4 col-md-3">
  <div class="thumbnail">

    <a href="{{ $moyu->path() }}">
      <img src="{{ $moyu->thumbnail }}" class="img-responsive" alt="">
    </a>
    <div class="caption">
      <a href="{{ $moyu->path() }}">
        <h5>
          {{ $moyu->title }}
        </h5>
      </a>

    </div>
    <div class="level">
      <ul class="list-inline">
        <li>
          <form action="{{ $moyu->path() }}" method="post">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}

            <button class="btn btn-xs btn-link" type="submit" name="button">X</button>
          </form>
        </li>
        <li>
          <span class="text-right">
            <a href="{{ $moyu->path() }}">{{ $moyu->replies_count }} {{ str_plural('reply', $moyu->replies_count) }}</a>
          </span>
        </li>
      </ul>
    </div>

  </div>
</div>
