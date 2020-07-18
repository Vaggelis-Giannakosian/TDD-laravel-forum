<?php


namespace App\Filters;


use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ThreadFilters extends Filters
{

    protected $filters = ['by'];


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


}
