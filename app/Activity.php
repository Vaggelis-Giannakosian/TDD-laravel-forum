<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = ['user_id','type', 'subject_id','subject_type','created_at'];

    public function subject()
    {
        return $this->morphTo('subject');
    }

    public static function feed(User $user, $take=50)
    {
        return static::where('user_id',$user->id)
            ->with('subject')
            ->latest()
            ->take($take)
            ->get()
            ->groupBy(function ($activity) {
            return $activity->created_at->format('Y-m-d');
        });
    }
}
