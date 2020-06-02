<?php


namespace App\Models\ModelProvider\impl;


use App\Models\Flat;
use App\Models\ModelProvider\IFlats;
use Eloquent;
use Illuminate\Database\Eloquent\Collection;

class Flats extends BaseModel implements IFlats
{

    function __construct($uid)
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
        $flat = new Flat($options);
        $flat->save();
        return $flat;
    }

    /**
     * @return Collection
     */
    function getAll()
    {
        return Flat::where('Flats.uid','=',$this->_user_id)->get();
    }

    /**
     * @param $id
     * @return Eloquent
     */
    function getById($id)
    {
        return Flat::find($id);
    }

    /**
     * @return Collection
     */
    public function getAllActive()
    {
        return Flat::where('Active','=',1)->where('uid','=',$this->_user_id)->get();
    }

    function getByBuildingId($id)
    {

        return Flat::where('BuildingId','=',$id)->where('uid','=',$this->_user_id)->get();
    }

    function getByBuildingIdWithoutOwner($id)
    {
        return Flat::select(array('Flats.*'))->leftJoin('Owners','Owners.FlatId','=','Flat.id')->where('Flat.Active','=',1)->where('Owners.id','=','NULL')->where('BuildingId','=',$id)->where('Flat.uid','=',$this->_user_id)->get();    }


    function getAllActiveWithoutOwner()
    {
        return Flat::select(array('Flats.*'))->leftJoin('Owners','Owners.FlatId','=','Flat.id')->where('Flat.Active','=',1)->where('Owners.id','=','NULL')->where('Flat.uid','=',$this->_user_id)->get();
    }
}