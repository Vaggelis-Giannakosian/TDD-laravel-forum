<?php

namespace App;

use App\Events\ThreadHasNewReply;
use App\Filters\ThreadFilters;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Elasticquent\ElasticquentTrait;
use Illuminate\Support\Str;


class Thread extends Model
{
    use RecordsActivity;


//    use ElasticquentTrait;


    protected $fillable = ['title', 'body', 'user_id', 'channel_id','slug'];
    //    protected $with = ['creator'];
    protected $with = ['channel'];

    protected $appends = ['isSubscribedTo'];

    protected static function boot()
    {
        parent::boot();

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
        if(static::whereSlug($slug = Str::slug($value))->exists()){
            $slug = $this->incrementSlug($slug);
        }

        $this->attributes['slug'] = $slug;
    }

    private function incrementSlug($slug)
    {
        $max = static::whereTitle($this->title)->latest('id')->value('slug');

        if(is_numeric($max[-1]))
        {
            return preg_replace_callback('/(\d)$/',fn($matches)=>$matches[1] + 1,$max);
        }

        return $slug.'-2';
    }


}
