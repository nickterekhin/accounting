<?php


namespace App\Models\ModelProvider\impl;


use App\Models\Discount;
use App\Models\ModelProvider\IDiscounts;
use Eloquent;
use Illuminate\Database\Eloquent\Collection;

class Discounts extends BaseModel implements IDiscounts
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
        $discount = new Discount($options);
        $discount->save();
        return $discount;
    }

    /**
     * @return Collection
     */
    function getAll()
    {
        return Discount::where("uid",'=',$this->_user_id)->get();
    }

    /**
     * @param $id
     * @return Eloquent
     */
    function getById($id)
    {
       return Discount::where("uid",'=',$this->_user_id)->find($id);
    }

    /**
     * @return Collection
     */
    public function getAllActive()
    {
       return Discount::where('Active','=',1)->where('uid','=',$this->_user_id)->get();
    }

    function getByOwnerId($id)
    {

        return Discount::where('OwnerId','=',$id)->where('uid','=',$this->_user_id)->get();
    }
}