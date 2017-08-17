<reply :attributes="{{ $reply }}" inline-template v-cloak>
  <div id="reply-{{ $reply->id }}"class="panel panel-default">
    <div class="panel-heading">
      <ul class="list-inline">
        <li>
          <a href="/profiles/{{ $reply->owner->name }}">
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
      <div v-if="editing">
        <div class="form-group">
          <textarea class="form-control" v-model="body"></textarea>
        </div>

        <button class="btn btn-xs btn-primary" @click="update">Update</button>
        <button class="btn btn-xs btn-link" @click="editing = false">Cancel</button>
      </div>

      <div v-else v-text="body"></div>
    </div>

    @can('update', $reply)
    <div class="panel-footer level">
      <button class="btn btn-xs mr-1" @click="editing = true">Edit</button>
      <button class="btn btn-danger btn-xs mr-1" @click="destory">Delete</button>
    </div>
    @endcan
  </div>
</reply>
