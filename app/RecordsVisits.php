<?php

namespace App;

use Illuminate\Support\Facades\Redis;

trait RecordsVisits
{
    public function resetVisits()
    {
        Redis::del($this->visitsCacheKey());
    }

    public function visitsCacheKey (){
        $prefix = app()->environment('testing') ? 'testing_' : '';
        return "{$prefix}threads:{$this->id}:visits";
    }

    public function recordVisit()
    {
        Redis::incr($this->visitsCacheKey());
    }

    public function visits()
    {
        return  Redis::get($this->visitsCacheKey()) ?? 0;
    }
}
