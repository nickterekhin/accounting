<?php


namespace App\Models\ModelProvider\impl;


use App\Models\ModelProvider\ITarifes;
use App\Models\Tarif;
use Eloquent;
use Illuminate\Database\Eloquent\Collection;

class Tarifes extends BaseModel implements ITarifes
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
        $options['uid'] =$this->_user_id;
        $tarif = new Tarif($options);
        $tarif->save();
        return $tarif;
    }

    /**
     * @return Collection
     */
    function getAll()
    {
        return Tarif::select("*")->where('uid','=',$this->_user_id)->get();
    }

    /**
     * @param $id
     * @return Eloquent
     */
    function getById($id)
    {
        return Tarif::find($id);
    }

    /**
     * @return Collection
     */
    public function getAllActive()
    {
        return Tarif::where('Active','=',1)->where('uid','=',$this->_user_id)->get();
    }

    function setInactiveExclude($exclude_id)
    {
        return Tarif::where("id","!=",$exclude_id)->where('uid','=',$this->_user_id)->update(array('Active'=>false));
    }

    function getActiveOne()
    {
        return Tarif::where('Active','=',1)->where('uid','=',$this->_user_id)->first();
    }


}