<?php


namespace App\Models\ModelProvider\impl;


use App\Models\Bank;
use App\Models\ModelProvider\IBanks;
use Eloquent;
use Illuminate\Database\Eloquent\Collection;

class Banks extends BaseModel implements IBanks
{

    private $_address_type = 2;
    private $fields = array('Banks.*','Address.City','Address.Street1','Address.Street2','Address.Zip');

    /**
     * Banks constructor.
     */
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
        $options['uid']=$this->_user_id;
        $hotel = new Bank($options);
        $hotel->save();
        return $hotel;
    }

    /**
     * @return Collection
     */
    function getAll()
    {
        return Bank::select($this->fields)->leftJoin('Address',function($lj){
            $lj->on('Address.ObjectId','=','Banks.id')->on('Address.TypeId','=',\DB::raw($this->_address_type));
        })->where('Banks.uid','=',$this->_user_id)->get();
    }



    /**
     * @param $id
     * @return Bank
     */
    function getById($id)
    {
       return Bank::select($this->fields)->leftJoin('Address',function($lj){
           $lj->on('Address.ObjectId','=','Banks.id')->on('Address.TypeId','=',\DB::raw($this->_address_type))->on('Address.Active','=',\DB::raw(1));
       })->where('Banks.Id','=',$id)->where('Bank.uid','=',$this->_user_id)->get()->first();
    }



    /**
     * @return Collection
     */
    public function getAllActive()
    {
        return Bank::select($this->fields)->leftJoin('Address','Address.ObjectId','=','Bank.Id')->where('Address.TypeId','=',$this->_address_type)->where('Address.Active','=',1)->where('Banks.Active','=',1)->where('Banks.uid','=',$this->_user_id)->orderBy('Banks.Title', 'Asc')->get();
    }
}