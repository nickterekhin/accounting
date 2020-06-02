<?php


namespace App\Models\ModelProvider\impl;


use App\Models\Address;
use App\Models\ModelProvider\IAddresses;
use Eloquent;
use Illuminate\Database\Eloquent\Collection;

class Addresses extends BaseModel implements IAddresses
{

    /**
     * @param array $options
     * @return Eloquent
     */
    function create(array $options)
    {
        $addr = new Address($options);
        $addr->save();
        return $addr;
    }

    /**
     * @return Collection
     */
    function getAll()
    {
        // TODO: Implement getAll() method.
    }

    function delete($object)
    {

        return $object->delete();
    }

    /**
     * @param $id
     * @return Eloquent
     */
    function getById($id)
    {
        // TODO: Implement getById() method.
    }

    /**


    /**
     * @return Collection
     */
    public function getAllActive()
    {
        // TODO: Implement getAllActive() method.
    }

    function getByTypeIdAndObjectId($type_id, $objectId)
    {
        return Address::where('TypeId','=',$type_id)->where('ObjectId','=',$objectId)->get()->first();
    }

    function getByTypeNameAndObjectId($type_name, $objectId)
    {
        return Address::select('Address.*')->join('AddressType','Address.TypeId','=','AddressType.id')->where('AddressType.TypeName','=',$type_name)->where('Address.ObjectId','=',$objectId)->get()->first();
    }


}
