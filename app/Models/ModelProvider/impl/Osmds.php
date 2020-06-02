<?php


namespace App\Models\ModelProvider\impl;


use App\Dobby\Dobby;
use App\Models\ModelProvider\IOsmd;
use App\Models\Osmd;
use App\Models\User;
use Eloquent;
use Illuminate\Database\Eloquent\Collection;

class Osmds extends BaseModel implements IOsmd
{


    private $_address_type = 1;
    private $fields = array('osmds.*','Address.City','Address.Street1','Address.Street2','Address.Zip');

    public function __construct($uid)
    {
        $this->_user_id = $uid;
    }


    /**
     * @param array $options
     * @return Eloquent
     */
    function create(array $options)
    {
        $options['uid'] = $this->_user_id;
       $osmd = new Osmd($options);
       $osmd->save();
       return $osmd;
    }

    /**
     * @return Collection
     */
    function getAll()
    {
        return Osmd::select($this->fields)->leftJoin('Address',function($lj){
            $lj->on('Address.ObjectId','=','osmds.id')->on('Address.TypeId','=',\DB::raw($this->_address_type));
        })->where('osmds.uid','=',$this->_user_id)->get();
    }



    /**
     * @param $id
     * @return Eloquent
     */
    function getById($id)
    {
        return Osmd::select($this->fields)->leftJoin('Address',function($lj){
            $lj->on('Address.ObjectId','=','osmds.id')->on('Address.TypeId','=',\DB::raw($this->_address_type))->on('Address.Active','=',\DB::raw(1));
        })->where('osmds.Id','=',$id)->where('osmds.uid','=',$this->_user_id)->get()->first();
    }



    /**
     * @return Collection
     */
    public function getAllActive()
    {
        return Osmd::select($this->fields)->leftJoin('Address','Address.ObjectId','=','osmds.Id')->where('Address.TypeId','=',$this->_address_type)->where('Address.Active','=',1)->where('osmds.Active','=',1)->where('osmds.uid','=',$this->_user_id)->orderBy('osmds.Title', 'Asc')->get();
    }
}