<?php


namespace App\Models\ModelProvider\impl;


use App\Models\Building;
use App\Models\ModelProvider\IBuildings;
use Eloquent;
use Illuminate\Database\Eloquent\Collection;

class Buildings extends BaseModel implements IBuildings
{

    private $_address_type = 3;
    private $fields = array('Buildings.*','Address.City','Address.Street1','Address.Street2','Address.Zip');

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
        $building = new Building($options);
        $building->save();
        return $building;
    }

    /**
     * @return Collection
     */
   function getAll()
    {
        return Building::select($this->fields)->leftJoin('Address',function($lj){
            $lj->on('Address.ObjectId','=','Buildings.id')->on('Address.TypeId','=',\DB::raw($this->_address_type));
        })->where('Buildings.uid','=',$this->_user_id)->get();
    }


    /**
     * @param $id
     * @return Eloquent
     */
    function getById($id)
    {
        return Building::select($this->fields)->leftJoin('Address',function($lj){
            $lj->on('Address.ObjectId','=','Buildings.id')->on('Address.TypeId','=',\DB::raw($this->_address_type))->on('Address.Active','=',\DB::raw(1));
        })->where('Buildings.Id','=',$id)->where('Buildings.uid','=',$this->_user_id)->get()->first();
    }



    /**
     * @return Collection
     */
    public function getAllActive()
    {
        return Building::select($this->fields)->leftJoin('Address','Address.ObjectId','=','Building.Id')->where('Address.TypeId','=',$this->_address_type)->where('Address.Active','=',1)->where('Buildings.Active','=',1)->where('Building.uid','=',$this->_user_id)->orderBy('Buildings.Title', 'Asc')->get();
    }
    /**
     * @return Collection
     */
    function getByOsmdId($osmd_id)
    {
        return Building::select($this->fields)->leftJoin('Address',function($lj){
            $lj->on('Address.ObjectId','=','Building.id')->on('Address.TypeId','=',\DB::raw($this->_address_type));
        })->where('OsmdId','=',$osmd_id)->where('Buildings.uid','=',$this->_user_id)->orderBy('Title')->get();
    }
}