<div class="panel panel-default">
  <div class="panel-heading">
    <ul class="list-inline">
      <li>
        <a href="/profiles/{{ $moyu->creator->name }}">
          {{ $reply->owner->name }}
        </a> said {{ $reply->created_at->diffForHumans() }}...
      </li>
      <li class="pull-right">
        <form action="/replies/{{ $reply->id }}/favorites" method="post">
          {{ csrf_field() }}
          <button class="btn btn-default btn-xs" type="submit" {{ $reply->isFavorited() ? 'disabled':'' }}>
            {{ $reply->favorites_count }} {{ str_plural('favorite', $reply->favorites_count) }}
          </button>
        </form>
      </li>
    </ul>
  </div>
  <div class="panel-body">
    {{ $reply->body }}
  </div>
</div>
