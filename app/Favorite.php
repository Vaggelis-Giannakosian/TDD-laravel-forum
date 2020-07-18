<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $fillable = ['user_id','favorable_type','favorable_id'];


    public function favorable()
    {
        return $this->morphTo();
    }
}
