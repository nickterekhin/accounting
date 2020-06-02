<?php


use App\Helpers\CRoutes;
use App\Helpers\CSubRoutes;

Route::get('/', array('as'=>'home','uses'=>'HomeController@index'));
Route::post('/login', array('as'=>'login','uses'=>'HomeController@login'));

Route::group(['middleware'=>['auth.dobby'],'prefix'=>'cpanel','role'=>'Panel'],function(){
    Route::get('/',['as'=>'cpanel',function(){
        return view('cpanel.home')->with(array('hideManageButtons'=>true));;
    }]);
    Route::get('logout',['as'=>'logout',function(){
        Dobby::logout();
        return redirect('/');
    }]);

    Route::group(['prefix'=>'osmd','middleware'=>'role.dobby','roles'=>'Osmd'],function(){
        CSubRoutes::getInstance()->routes('building',array('all','add','edit','del'),'Building');
       /* Route::get('{id}/building/{action}/{obj_id?}',array('as'=>'osmd.building','uses'=>'CPanel\OsmdController@building'))->where('action','all|add|del');*/
        CRoutes::getInstance()->routes('osmd','Osmd');
    });
    Route::group(['prefix'=>'bank','middleware'=>'role.dobby','roles'=>'Bank'],function(){
        CRoutes::getInstance()->routes('bank','Bank');
    });

    Route::group(['prefix'=>'building','middleware'=>'role.dobby','roles'=>'Building'],function(){
        CSubRoutes::getInstance()->routes('flat',array('all','add','edit','del'),'Flat');
        CRoutes::getInstance()->routes('building','Building');
    });

    Route::group(['prefix'=>'flats','middleware'=>'role.dobby','roles'=>'Flat'],function(){
        CSubRoutes::getInstance()->routes('owner',array('all','add','edit','del'),'Owner');
        CSubRoutes::getInstance()->routes('receipt',array('all','add','edit','del','view'),'Receipt');
       /* Route::get('{id}/receipt/{action}/{receipt_id?}',array('as'=>'flats.receipt','uses'=>'CPanel\FlatController@receipt'))->where('action','all|add|del');*/
        CRoutes::getInstance()->routes('flats','Flat');
    });
    Route::group(['prefix'=>'owner','middleware'=>'role.dobby','roles'=>'Owner'],function(){
        CSubRoutes::getInstance()->routes('discount',array('all','add','edit','del'),'Discount');
        CRoutes::getInstance()->routes('owner','Owner');
    });
    Route::group(['prefix'=>'tarif','middleware'=>'role.dobby','roles'=>'Tarif'],function(){
        CRoutes::getInstance()->routes('tarif','Tarif');
    });
    Route::group(['prefix'=>'receipt','middleware'=>'role.dobby','roles'=>'Receipt'],function(){

        CSubRoutes::getInstance()->routes('payment',array('all','add','edit','del'),'Payment');
        CRoutes::getInstance()->routes('receipt','Receipt');
    });


    Route::group(['prefix'=>'payment','middleware'=>'role.dobby','roles'=>'Payment'],function(){

        CRoutes::getInstance()->routes('payment','Payment');
    });
    Route::group(['prefix'=>'ajax'],function(){
        Route::any('buildings',array('as'=>'buildings','uses'=>'ajax\DropDownController@driver'));
    });

});

