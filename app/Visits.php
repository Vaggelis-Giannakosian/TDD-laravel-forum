<?php


namespace App;


use Illuminate\Support\Facades\Redis;

class Visits
{
    protected $thread;

    public function __construct($thread)
    {
        $this->thread = $thread;
    }

    public function reset(){
        Redis::del($this->cacheKey());
    }

    public function record()
    {
        Redis::incr($this->cacheKey());
    }

    public function count(){
        return  Redis::get($this->cacheKey()) ?? 0;
    }

    public function cacheKey (){
        $prefix = app()->environment('testing') ? 'testing_' : '';
        return "{$prefix}threads:{$this->thread->id}:visits";
    }
}
