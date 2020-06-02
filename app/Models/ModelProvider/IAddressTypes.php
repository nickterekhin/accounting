<?php


namespace App\Models\ModelProvider;


interface IAddressTypes extends IBaseModel
{
    function getByTypeName($type_name);

}