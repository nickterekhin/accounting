<?php


namespace App\Models\ModelProvider\impl;


use App\Models\ModelProvider\IOwners;
use App\Models\Owner;
use Eloquent;
use Illuminate\Database\Eloquent\Collection;

class Owners extends BaseModel implements IOwners
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
        $owner = new Owner($options);
        $owner->save();
        return $owner;
    }

    /**
     * @return Collection
     */
    function getAll()
    {
        return Owner::select('*')->where('uid','=',$this->_user_id)->get();
    }

    /**
     * @param $id
     * @return Eloquent
     */
    function getById($id)
    {
        return Owner::find($id);
    }

    /**
     * @return Collection
     */
    public function getAllActive()
    {
        return Owner::where("Active",'=','1')->where('uid','=',$this->_user_id)->get();
    }

    function deactivateAllButThis($exclude_id,$flatId)
    {
        return Owner::where("id","!=",$exclude_id)->where("uid","=",$this->_user_id)->where('FlatId','=',$flatId)->update(array("Active"=>false));
    }

    function getByFlatId($id)
    {
        return Owner::where('uid','=',$this->_user_id)->where('FlatId','=',$id)->get();
    }

}