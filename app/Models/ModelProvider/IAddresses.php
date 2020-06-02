<?php


namespace App\Models\ModelProvider;


interface IAddresses extends IBaseModel
{
    function getByTypeIdAndObjectId($type_id,$objectId);
    function getByTypeNameAndObjectId($type_name,$objectId);
}