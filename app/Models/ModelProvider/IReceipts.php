<?php


namespace App\Models\ModelProvider;


interface IReceipts extends IBaseModel
{
    function initModel($flat_id, $tarif_id,$month=null);

    function getByYearMonthAndFlatId($flat_id, $year, $month);
    function getLastByFlatId($flat_id);
    function getAllByFlatId($flat_id);
}