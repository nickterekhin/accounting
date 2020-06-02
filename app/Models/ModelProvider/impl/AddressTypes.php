<?php


namespace App\Models\ModelProvider\impl;


use App\Models\AddressType;
use App\Models\ModelProvider\IAddressTypes;
use Eloquent;
use Illuminate\Database\Eloquent\Collection;

class AddressTypes extends BaseModel implements IAddressTypes
{

    /**
     * @param array $options
     * @return Eloquent
     */
    function create(array $options)
    {
        // TODO: Implement create() method.
    }

    /**
     * @return Collection
     */
    function getAll()
    {
        // TODO: Implement getAll() method.
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
     * @return Collection
     */
    public function getAllActive()
    {
        // TODO: Implement getAllActive() method.
    }

    function getByTypeName($type_name)
    {
        return AddressType::where('TypeName','=',$type_name)->get()->first();
    }
}