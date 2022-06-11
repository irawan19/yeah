<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class CekUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::user()->tipe_users_id == 1)
        {
            if(Auth::user()->user_statuses_id != 2)
            {
                $check_session = \App\Models\Session::where('user_id',Auth::user()->id)->count();
                if($check_session != 0)
                    \App\Models\Session::where('user_id',Auth::user()->id)->delete();
                
                $users_data = [
                    'remember_token'    => ''
                ];
                \App\Models\User::where('id',Auth::user()->id)
                                ->update($users_data);
                return redirect('/login');
            }
            else
                return $next($request);
        }
        else
            return redirect('/login');
    }
}
