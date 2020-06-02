<?php


namespace App\Models\ModelProvider;


interface IDiscounts extends IBaseModel
{
    function getByOwnerId($id);
}