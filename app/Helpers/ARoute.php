<?php


namespace App\Helpers;



use Route;

abstract class ARoute{
    private static $_instances = array();
    protected $controller_name;
    protected $route_group_params=array(
        'middleware'=>'role.dobby'
    );

    /**
     * CRoute constructor.
     * @param $controller_name
     * @param array $route_group_params
     */
    public function __construct($controller_name,$route_group_params=array())
    {
        $this->route_group_params =$this->parse($route_group_params,$this->route_group_params);
        $this->controller_name = $controller_name;
    }

    public function init_route()
    {
        Route::group($this->route_group_params,function($this){
            $this->routes();
        });
    }
    protected function routes()
    {
        Route::get('/',array('as'=>$this->route_group_params['prefix'],'uses'=>'Admin\\'.$this->controller_name.'Controller@index'));
        Route::get('/create',array('as'=>$this->route_group_params['prefix'].'.create','uses'=>'Admin\\'.$this->controller_name.'Controller@create'));
        Route::post('create',array('as'=>$this->route_group_params['prefix'].'.create','uses'=>'Admin\\'.$this->controller_name.'Controller@store'));
        Route::get('edit/{id}',array('as'=>$this->route_group_params['prefix'].'.edit','uses'=>'Admin\\'.$this->controller_name.'Controller@edit'));
        Route::post('edit/{id}',array('as'=>$this->route_group_params['prefix'].'.edit','uses'=>'Admin\\'.$this->controller_name.'Controller@update'));
        Route::get('delete/{id}',array('as'=>$this->route_group_params['prefix'].'.delete','uses'=>'Admin\\'.$this->controller_name.'Controller@delete'));
        Route::get('{active}/{id}', array('as'=>$this->route_group_params['prefix'].'.activate', 'uses'=>'Admin\\'.$this->controller_name.'Controller@openClose'));
    }
    private function parse($attr,$default_attr)
    {
        foreach($attr as $k => $v)
        {
            $default_attr[$k]=$v;
        }
        return $default_attr;
    }

    /**
     * @param $controller_name
     * @return ARoute
     */
    public static function getInstance($controller_name) {
        $class = get_called_class();
        if (!isset(self::$_instances[$class])) {
            self::$_instances[$class] = new $class($controller_name);
        }
        return self::$_instances[$class];
    }
}
