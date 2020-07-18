<?php


namespace App\Filters;


use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ThreadFilters extends Filters
{

    protected $filters = ['by','popular'];


    /**
     * @param $username
     * @param Builder $builder
     * @return Builder
     */
    protected function by($username): Builder
    {
        $user = User::where('name', $username)->firstOrFail();
        return $this->builder->where('user_id', $user->id);
    }

    /**
     * Filter the query according to most popular threads
     * @return Builder
     */
    protected function popular($order): Builder
    {
        $this->builder->getQuery()->orders = [];
        return $this->builder->orderBy('replies_count','desc');
    }


}
