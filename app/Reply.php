<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use Favoritable, RecordsActivity;

    protected $guarded = [];

    protected $with = ['owner', 'favorites'];

    protected $appends = ['favoritesCount', 'isFavorited'];

    protected static function boot()
    {
      parent::boot();

      static::created(function($reply){
        $reply->moyu->increment('replies_count');
      });

      static::deleted(function($reply){
        $reply->moyu->decrement('replies_count');
      });
    }

    public function moyu()
    {
      return $this->belongsTo('App\Moyu');
    }

    public function owner()
    {
      return $this->belongsTo('App\User', 'user_id');
    }

    public function path()
    {
       return $this->moyu->path() . "/#reply-{$this->id}";
    }
  }
