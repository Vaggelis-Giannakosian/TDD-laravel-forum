<?php

namespace App\Http\Middleware;

use Closure;

class Administrator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if( !auth()->check() || ! auth()->user()->isAdmin()){

            if(request()->wantsJson())
            {
                return response('You do not have permission to lock this thread',403);
            }

            return redirect(route('threads.index'));
        }

        return $next($request);
    }
}
