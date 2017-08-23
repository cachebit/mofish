<div class="col-xs-6 col-sm-4 col-md-3">
  <div class="thumbnail">

    <a href="{{ $moyu->path() }}">
      <img src="{{ $moyu->thumbnail }}" class="img-responsive" alt="">
    </a>
    <div class="caption">

      <h5>
        <a href="{{ $moyu->path() }}">
          @if(auth()->check() and $moyu->hasUpdatesFor(auth()->user()))
            <strong>
              {{ $moyu->title }}
            </strong>
          @else
            {{ $moyu->title }}
          @endif
        </a>
      </h5>

    </div>
    <div class="level">
      <ul class="list-inline">
        @can ('update', $moyu)
        <li>
          <form action="{{ $moyu->path() }}" method="post">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}

            <button class="btn btn-xs btn-link" type="submit" name="button">X</button>
          </form>
        </li>
        @endcan
        <li>
          <span class="text-right">
            <a href="{{ $moyu->path() }}">{{ $moyu->replies_count }} {{ str_plural('reply', $moyu->replies_count) }}</a>
          </span>
        </li>
      </ul>
    </div>

  </div>
</div>
