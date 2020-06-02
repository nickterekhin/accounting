<?php


namespace App\Models\ModelProvider\impl;


use App\Models\ModelProvider\IBaseModel;
use Eloquent;

abstract class BaseModel
{
    protected $_user_id;
    /**
     * @param Eloquent $object
     * @return bool
     */
    function update($object)
    {
        return $object->update();
    }
    /**
     * @param Eloquent $object
     * @return bool
     * @throws \Exception
     */
    function delete($object)
    {
        if($this->_user_id!=-1)
            $object->setUid($this->_user_id);
        return $object->delete();
    }

}