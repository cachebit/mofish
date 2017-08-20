<?php

namespace App;

use App\Notifications\MoyuWasUpdated;
use Illuminate\Database\Eloquent\Model;

class MoyuSubscription extends Model
{
    protected $guarded = [];

    public function user()
    {
      return $this->belongsTo(User::class);
    }

    public function moyu()
    {
      return $this->belongsTo(Moyu::class);
    }

    public function notify($reply)
    {
      $this->user->notify(new MoyuWasUpdated($this->moyu, $reply));
    }
}
