@component('profiles.activities.activity')
  @slot('heading')
  <h4>
    <a href="{{ $activity->subject->favorited->path() }}">
      {{ $profileUser->name }} favorited a reply.
    </a>
  </h4>
  @endslot
  @slot('body')
  <p>{{ $activity->subject->favorited->body }}</p>
  @endslot
@endcomponent
