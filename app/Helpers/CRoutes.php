<?php

namespace App\Helpers;;

use Route;

class CRoutes
{
    private static $instance;
    private function __construct()
    {

    }
    public static function getInstance()
    {
        if(!self::$instance)
        {
            self::$instance = new self();
        }
        return self::$instance;
    }
     function routes($prefix,$controller_name)
    {
        Route::get('/',array('as'=>$prefix,'uses'=>$this->getControllerName($controller_name,'index')));
        Route::get('create',array('as'=>$prefix.'.create','uses'=>$this->getControllerName($controller_name,'create')));
        Route::post('create',array('as'=>$prefix.'.create','uses'=>$this->getControllerName($controller_name,'store')));
        Route::get('view/{id}',array('as'=>$prefix.'.view','uses'=>$this->getControllerName($controller_name,'view_receipt')));
        Route::get('edit/{id}',array('as'=>$prefix.'.edit','uses'=>$this->getControllerName($controller_name,'edit')));
        Route::post('edit/{id}',array('as'=>$prefix.'.edit','uses'=>$this->getControllerName($controller_name,'update')));
        Route::get('delete/{id}',array('as'=>$prefix.'.delete','uses'=>$this->getControllerName($controller_name,'destroy')));
        Route::get('{active}/{id}', array('as'=>$prefix.'.activate', 'uses'=>$this->getControllerName($controller_name,'openClose')))->where('active','open|close');

    }
    private function getControllerName($prefix_name,$action_name)
    {
        return 'CPanel\\'.$prefix_name.'Controller@'.$action_name;
    }
}