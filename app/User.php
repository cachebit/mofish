<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'email',
    ];


    public function getRouteKeyName()
    {
        return 'name';
    }

    public function moyus()
    {
        return $this->hasMany('App\Moyu')->latest();
    }

    public function activity()
    {
        return $this->hasMany('App\Activity');
    }

    public function read($moyu)
    {
      cache()->forever(
        $this->visitedMoyuCacheKey($moyu),
        \Carbon\Carbon::now()
      );

    }

    public function visitedMoyuCacheKey($moyu)
    {
        return sprintf("user.%s.visits.%s", $this->id, $moyu->id);
    }
}
