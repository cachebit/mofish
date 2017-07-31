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
}
