<?php


namespace App\Models\ModelProvider;


interface IBuildings extends IBaseModel
{

    function getByOsmdId($osmd_id);
}