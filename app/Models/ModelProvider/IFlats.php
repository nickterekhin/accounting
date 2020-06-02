<?php


namespace App\Models\ModelProvider;


interface IFlats extends IBaseModel
{
    function getByBuildingId($id);
    function getByBuildingIdWithoutOwner($id);
    function getAllActiveWithoutOwner();
}