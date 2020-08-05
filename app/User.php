<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','avatar_path',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','email'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function path()
    {
        return route('user.profile',$this);
    }

    public function threads()
    {
        return $this->hasMany(Thread::class)->latest();
    }

    public function activity()
    {
        return $this->hasMany(Activity::class)->latest();
    }

    public function visitedThreadCacheKey(Thread $thread)
    {
        return sprintf("users.%s.visits.%s",$this->id,$thread->id);
    }

    public function read($thread)
    {
        cache()->forever(
            auth()->user()->visitedThreadCacheKey($thread),
            now()
        );
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function lastReply()
    {
        return $this->hasOne(Reply::class)->latest();
    }
}
