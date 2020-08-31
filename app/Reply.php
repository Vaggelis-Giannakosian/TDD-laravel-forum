<?php

namespace App;


use App\Notifications\YourWereMentioned;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{

    use Favorable, RecordsActivity;

    protected $fillable = ['thread_id', 'user_id', 'body'];

    protected $with = ['owner', 'favorites'];

    protected $appends = [ 'favoritesCount','isFavorited'];

    public static function boot()
    {
        parent::boot();

        static::created(function($reply){
            $reply->thread->increment('replies_count');
        });

        static::deleted(function($reply){
            $reply->thread->decrement('replies_count');
        });
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    public function path()
    {
        return $this->thread->path()."/#reply-{$this->id}";
    }

    public function wasJustPublished()
    {
        return $this->created_at->gt(now()->subMinute());
    }

    public function mentionedUsers()
    {
        //inspect body of the reply for username mentions
        preg_match_all('/\@([\w\-]+)/',$this->body,$matches);

        return $matches[1];
    }

    public function setBodyAttribute($body)
    {
        $this->attributes['body'] = preg_replace('/\@([\w\-]+)/','<a href="/profiles/$1">$0</a>',$body);
    }

    public function isBest()
    {
        return $this->thread->best_reply_id == $this->id;
    }

}
