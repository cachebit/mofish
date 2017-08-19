<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Moyu extends Model
{
    use RecordsActivity;

    protected $guarded = [];

    protected $with = ['creator', 'channel'];

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
      return $this->replies()->create($reply);
    }

    public function scopeFilter($query, $filters)
    {
      return $filters->apply($query);
    }

    public function activity()
    {
      return $this->morphMany('App\Activity', 'subject');
    }
}
