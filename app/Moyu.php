<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Moyu extends Model
{
    use RecordsActivity;

    protected $guarded = [];

    protected $with = ['creator', 'channel'];

    protected $appends = ['isSubscribedTo'];

    protected static function boot()
    {
      parent::boot();

      static::deleting(function($moyu){
        $moyu->replies->each->delete();
      });
    }

    public function path()
    {
      return "/moyus/{$this->channel->slug}/{$this->id}";
    }

    public function replies()
    {
      return $this->hasMany('App\Reply');
    }

    public function creator()
    {
      return $this->belongsTo('App\User', 'user_id');
    }

    public function channel()
    {
      return $this->belongsTo('App\Channel');
    }

    public function addReply($reply)
    {

      $reply = $this->replies()->create($reply);

      $this->notifySubscribers($reply);

      return $reply;
    }

    public function notifySubscribers($reply)
    {
      $this->subscriptions
        ->where('user_id', '!=', $reply->user_id)
        ->each
        ->notify($reply);
    }

    public function scopeFilter($query, $filters)
    {
      return $filters->apply($query);
    }

    public function activity()
    {
      return $this->morphMany('App\Activity', 'subject');
    }

    public function subscribe($userId = null)
    {
        $this->subscriptions()->create([
          'user_id' => $userId ?: auth()->id(),
        ]);

        return $this;
    }

    public function unsubscribe($userId = null)
    {
        $this->subscriptions()
             ->where('user_id', $userId ?: auth()->id())
             ->delete();
    }

    public function subscriptions()
    {
      return $this->hasMany(MoyuSubscription::class);
    }

    public function getIsSubscribedToAttribute()
    {
        return $this->subscriptions()
          ->where('user_id', auth()->id())
          ->exists();
    }

    public function hasUpdatesFor($user)
    {
        $key = $user->visitedMoyuCacheKey($this);

        return $this->updated_at > cache($key);
    }
}
