<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Moyu extends Model
{
    protected $guarded = [];

    protected static function boot()
    {
      parent::boot();

      static::addGlobalScope('replyCount', function($builder){
        $builder->withCount('replies');
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
      $this->replies()->create($reply);
    }
}
