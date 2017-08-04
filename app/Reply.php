<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $guarded = [];

    public function moyu()
    {
      return $this->belongsTo('App\Moyu');
    }

    public function owner()
    {
      return $this->belongsTo('App\User', 'user_id');
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }

    public function favorite()
    {
        $attribute = ['user_id' => auth()->id()];
        if(! $this->favorites()->where($attribute)->exists()){
          $this->favorites()->create($attribute);
        }
    }
}
