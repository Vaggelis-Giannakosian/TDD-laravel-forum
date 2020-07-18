<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{

    use Favorable;

    protected $fillable = ['thread_id', 'user_id', 'body'];

    protected $with = ['owner','favorites'];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


}
