<?php


namespace App\Models\ModelProvider;


interface IOwners extends IBaseModel
{
    function deactivateAllButThis($exclude_id,$flatId);
    function getByFlatId($id);
}