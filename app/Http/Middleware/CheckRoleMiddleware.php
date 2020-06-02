<?php

namespace App\Http\Middleware;

use Closure;

class CheckRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $role = $this->getRolesFromAction($request->route());


        if(!$role || \Dobby::checkRights($role)){

            return $next($request);
        }
        else
        {

            return \Redirect::to('admin')->with(array('form-message'=>'You are not authorized to access this resource.','form-message-type'=>'alert-danger'));
        }



    }

    private function getRolesFromAction($route)
    {
        $actions = $route->getAction();

        return isset($actions['roles']) ? $actions['roles'] : null;
    }
}
