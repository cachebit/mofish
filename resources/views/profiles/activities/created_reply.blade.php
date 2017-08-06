@component('profiles.activities.activity')
  @slot('heading')
  <h4>
    {{ $profileUser->name }} replied to
    "<a href="{{ $activity->subject->moyu->path() }}">{{ $activity->subject->moyu->title }}</a>"
    <small>{{ $activity->subject->created_at->diffForHumans() }}</small>
  </h4>
  @endslot
  @slot('body')
  <p>{{ $activity->subject->body }}</p>
  @endslot
@endcomponent
