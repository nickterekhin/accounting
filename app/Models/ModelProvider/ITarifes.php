<?php


namespace App\Models\ModelProvider;


interface ITarifes extends IBaseModel
{
    function setInactiveExclude($exclude_id);
    function getActiveOne();
}