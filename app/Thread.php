<?php

namespace App;

use App\Events\ThreadHasNewReply;
use App\Filters\ThreadFilters;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Elasticquent\ElasticquentTrait;
use Illuminate\Support\Str;
use Stevebauman\Purify\Facades\Purify;


class Thread extends Model
{
    use RecordsActivity;


//    use ElasticquentTrait;

    protected $casts = [
        'locked'=>'boolean'
    ];

    protected $fillable = ['title', 'body', 'user_id', 'channel_id','slug','best_reply_id','locked'];
    //    protected $with = ['creator'];
    protected $with = ['channel'];

    protected $appends = ['isSubscribedTo'];

    protected static function boot()
    {
        parent::boot();

        static::created(function($thread){
            $thread->update(['slug'=>$thread->title]);
        });

        static::addGlobalScope('creator', function (Builder $builder) {
            $builder->with('creator');
        });

        static::deleting(function ($thread) {
            $thread->replies->each->delete();
        });

    }


    public function replies()
    {
        return $this->hasMany(Reply::class)
            ->orderBy('created_at', 'desc');
    }

//    public function getReplyCountAttribute()
//    {
//        return $this->replies()->count();
//    }


    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function path()
    {
        return "/threads/{$this->channel->slug}/{$this->slug}";
    }

    public function addReply($reply)
    {
        $reply = $this->replies()->create($reply);

        event(new ThreadHasNewReply($this,$reply));

        return $reply;
    }


    public function scopeFilter(Builder $query, ThreadFilters $filters)
    {
        return $filters->apply($query);
    }

    public function subscribe($userId = null)
    {
        $this->subscriptions()->create([
            'user_id' => $userId ?: auth()->id()
        ]);

        return $this;
    }

    public function unsubscribe($userId = null)
    {
        return $this->subscriptions()
            ->where('user_id', $userId ?: auth()->id())
            ->delete();
    }


    public function subscriptions()
    {
        return $this->hasMany(ThreadSubscription::class);
    }

    public function getIsSubscribedToAttribute()
    {
        return $this->subscriptions()
            ->where('user_id', auth()->id())
            ->exists();
    }

    public function hasUpdatesFor($user = null)
    {

        //look in the cache the proper key
        $user = $user ?: auth()->user();
        $key = $user->visitedThreadCacheKey($this);

        //compare that carbon instance with the last updated at timestamp
        return $this->updated_at > cache($key);

    }

    public function visits()
    {
        return new Visits($this);
    }

    public function setSlugAttribute($value)
    {
        $slug = Str::slug($value);

        if(static::whereSlug($slug)->exists()){
            $slug = "{$slug}-".$this->id;
        }

        $this->attributes['slug'] = $slug;
    }

    public function markBestReply(Reply $reply)
    {
        $this->update(['best_reply_id'=>$reply->id]);
    }

    public function lock($lock=true)
    {
        $this->update(['locked'=>$lock]);
    }


    public function unlock()
    {
        $this->lock(false);
    }

    public function getBodyAttribute($body)
    {
        return Purify::clean($body);
    }


}
