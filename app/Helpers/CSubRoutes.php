<?php


namespace App\Helpers;


use Route;

class CSubRoutes
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
    function routes($prefix,$actions=array(),$controller_name)
    {
        foreach ($actions as $a)
        {
            Route::get('{id}/'.$prefix.'/'.$a.'/{obj_id?}',array('as'=>'sub.'.$prefix.'.'.$a,'uses'=>$this->getControllerName($controller_name,$prefix.'_'.$a)));
        }
        $post_actions = array_filter($actions,function($item){
            return $item=='edit' || $item=='add';
        });
        foreach ($post_actions as $pa)
        {
            Route::post('{id}/'.$prefix.'/'.$pa.'/{obj_id?}',array('as'=>'sub.'.$prefix.'.'.$pa,'uses'=>$this->getControllerName($controller_name,$prefix.'_'.$pa.'_post')));
        }

    }
    private function getControllerName($prefix_name,$action_name)
    {
        return 'CPanel\\'.$prefix_name.'Controller@'.$action_name;
    }
}