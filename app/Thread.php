<?php

namespace App;

use App\Filters\ThreadFilters;
use Illuminate\Database\Eloquent\Model;
use Elasticquent\ElasticquentTrait;

class Thread extends Model
{

//    use ElasticquentTrait;

    protected $fillable = ['title','body','user_id','channel_id'];


    public function replies()
    {
        return $this->hasMany(Reply::class)->orderBy('created_at','desc');
    }


    public function creator()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function path()
    {
        return "/threads/{$this->channel->slug}/{$this->id}";
    }

    public function addReply($reply)
    {
        $this->replies()->create($reply);
    }

    public function scopeFilter($query, ThreadFilters $filters)
    {
        return $filters->apply($query);
    }
}
