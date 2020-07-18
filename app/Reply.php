<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $fillable = ['thread_id', 'user_id', 'body'];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorable');
    }

    public function favorite()
    {
        $attributes = ['user_id' => auth()->id()];

        if(!$this->favorites()->where($attributes)->exists())
        {
            $this->favorites()->create($attributes);
        }

    }

}
