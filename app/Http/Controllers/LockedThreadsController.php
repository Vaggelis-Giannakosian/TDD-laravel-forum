<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Thread;
use Illuminate\Http\Request;

class LockedThreadsController extends Controller
{
    public function store(Thread $thread)
    {
        $thread->lock();
    }
}
