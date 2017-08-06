@component('profiles.activities.activity')
  @slot('heading')
    <h4>
      {{ $profileUser->name }} published moyu:
      "<a href="{{ $activity->subject->path() }}">{{ $activity->subject->title }}</a>"
      <small>{{ $activity->subject->created_at->diffForHumans() }}</small>
    </h4>
  @endslot
  @slot('body')
  <img src="{{ $activity->subject->img }}" class="img-responsive" alt="">
  @endslot
@endcomponent
