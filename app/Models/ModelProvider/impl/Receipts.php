<?php


namespace App\Models\ModelProvider\impl;


use App\Models\ModelProvider\IReceipts;
use App\Models\Receipt;
use Eloquent;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class Receipts extends BaseModel implements IReceipts
{

    function __construct($uid)
    {

        $this->_user_id = $uid;
    }

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
        return Receipt::where('uid','=',$this->_user_id)->selectRaw("Receipt.*,GetFinDataByReceiptId(Receipt.Id,1) as Outstanding, GetFinDataByReceiptId(Receipt.Id,0) as Overpaid ")->get();
    }

    /**
     * @param $id
     * @return Eloquent
     */
    function getById($id)
    {
        return Receipt::where('uid','=',$this->_user_id)->selectRaw("Receipt.*,GetFinDataByFlatId(Receipt.FlatId,Receipt.Month,Receipt.Year,1) as Outstanding, GetFinDataByFlatId(Receipt.FlatId,Receipt.Month,Receipt.Year,0) as Overpaid ")->find($id);
    }

    /**
     * @return Collection
     */
    public function getAllActive()
    {
        // TODO: Implement getAllActive() method.
    }

    /**
     * @param $flat_id
     * @param $tarif_id
     * @param null $month
     * @return Receipt
     * @throws Exception
     */
    function initModel($flat_id, $tarif_id,$month=null)
    {

        $receipt = new Receipt();
        $receipt->setUid($this->_user_id);
        $receipt->setFlatId($flat_id);
        $receipt->setTarifId($tarif_id);
        $receipt->setAmount(0);
        $prev_receipt = $this->getLastByFlatId($flat_id);
        if($prev_receipt)
            $receipt->setNumber($prev_receipt->getNumber()+1);

        $now = time();
        $receipt->setMonth($month!=null?$month:date("d",$now));
        $receipt->setYear(date("Y",$now));
        $receipt->setCreated($now);
        if($prev_receipt && $receipt->getYear() == $prev_receipt->getYear() && $receipt->getMonth() == $prev_receipt->getMonth())
            throw new Exception("Receipt already exists");

         $receipt->save();
         return $receipt;

    }



    function getByYearMonthAndFlatId($flat_id,$year,$month)
    {
        return Receipt::selectRaw("Receipt.*,GetFinDataByReceiptId(Receipt.Id,1) as Outstanding, GetFinDataByReceiptId(Receipt.Id,0) as Overpaid ")->where("FlatId","=",$flat_id)->where("Year","=",$year)->where("Month","=",$month)->where('uid','=',$this->_user_id)->first();
    }

    function getLastByFlatId($flat_id)
    {
        return Receipt::whereRaw("Number = (select max(Number) FROM Receipt) AND FlatId = {$flat_id} AND uid={$this->_user_id}")->first();
        //return Receipt::where("FlatId","=",$flat_id)->OrderByDesc("Month")->OrderByDesc("Year")->get()->first();
    }

    function getAllByFlatId($flat_id)
    {
        return Receipt::selectRaw("Receipt.*,GetFinDataByReceiptId(Receipt.Id,1) as Outstanding, GetFinDataByReceiptId(Receipt.Id,0) as Overpaid ")->where('FlatId','=',$flat_id)->where('uid','=',$this->_user_id)->orderByDesc("Receipt.Month")->get();
    }


}