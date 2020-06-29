<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Date;

class CheckAuth
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
        $token = $request->bearerToken();
        $user = User::where('token', $token)->first();
        if ($user) {
            if((new \DateTime())->modify('+1 day')->getTimestamp() > (new \DateTime($user->expired_at))->getTimestamp()){
                return $next($request);
            }
        }
        return response(['message' => ['status' => false, 'text'=>'Unauthenticated']], 401);


    }
}
