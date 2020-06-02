<?php

namespace App\Http\Middleware;

use Closure;

class InitUserMiddleware
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
        \Dobby::initUser();
        \Dobby::checkUserState();
        ////return \Redirect::to('/admin/maintenance');
        if(!\Dobby::isLoggedIn())
        {
            $redirect = \Dobby::getRedirectRouteFromAction($request->route());

            if($redirect) {
                return \Redirect::to($redirect);
            }

                return \Redirect::to('/');
        }
        else
        {

            if(\Dobby::checkRights('Panel')) {
               return $next($request);
            }
            return \Redirect::to('/');

        }


    }
}
