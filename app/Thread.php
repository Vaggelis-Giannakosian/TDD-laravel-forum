<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    protected $fillable = ['title','body','user_id'];


    public function replies()
    {
        return $this->hasMany(Reply::class)->orderBy('created_at','desc');
    }


    public function creator()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function path()
    {
        return route('threads.show',$this);
    }

    public function addReply($reply)
    {
        $this->replies()->create($reply);
    }
}
