<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Moyu extends Model
{
    public function path()
    {
      return '/moyus/' . $this->id;
    }

    public function replies()
    {
      return $this->hasMany('App\Reply');
    }
}
