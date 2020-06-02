<?php

namespace App\Dobby;


use App\Dobby\ModelProviders\Impl\UsersModelImpl;
use Illuminate\Support\ServiceProvider;

class DobbyProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

        $this->registerUserProvider();

        $this->app->bind('dobby',function($app){
             return new Dobby($app['dobby.user'],$app['request'],$app['cookie']);
        });
        $this->app->alias('dobby','App\Dobby\Dobby');

    }

    protected function registerUserProvider()
    {

        $this->app->singleton('dobby.user',function($app){

            return new UsersModelImpl();
        });

        $this->app->bind('App\Dobby\ModelProviders\IUser','App\Dobby\ModelProviders\Impl\UsersModelImpl');
        $this->app->bind('App\Dobby\ModelProviders\IUserGroup','App\Dobby\ModelProviders\Impl\UserGroupModelImpl');
        $this->app->bind('App\Dobby\ModelProviders\IPermission','App\Dobby\ModelProviders\Impl\PermissionModelImpl');
    }
}