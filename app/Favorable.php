<?php

namespace App;

trait Favorable
{
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

    public function unfavorite()
    {
        $attribute = ['user_id' => auth()->id()];

        $this->favorites()->where($attribute)->delete();
    }

    public function isFavorited()
    {
        return !! $this->favorites->where('user_id', auth()->id())->count();
    }

    public function getIsFavoritedAttribute()
    {
        return $this->isFavorited();
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }
}
