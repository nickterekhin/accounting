<?php


namespace App\Models\ModelProvider\impl;


use App\Models\ModelProvider\IPayments;
use App\Models\Payment;
use Eloquent;
use Illuminate\Database\Eloquent\Collection;

class Payments extends BaseModel implements IPayments
{
    private $_receipt_id;

    /**
     * Payments constructor.
     */
    public function __construct($uid)
    {
        $this->_user_id = $uid;
    }

    function setReceiptId($receipt_id)
    {
        $this->_receipt_id = $receipt_id;
    }

    /**
     * @param array $options
     * @return Eloquent
     */
    function create(array $options)
    {
        $options['uid'] = $this->_user_id;
        $payment = new Payment($options);
        $payment->save();
        return $payment;
    }

    /**
     * @return Collection
     */
    function getAll()
    {

        $results =  \DB::select("CALL GetPaymentsByReceiptIdAndUid(?, ?)",array($this->_receipt_id,$this->_user_id));

        return collect($results)->map(function($r){

            $payment = new Payment();
            $payment->setId($r->id);
            $payment->setUid($r->uid);
            $payment->setReceiptId($r->ReceiptId);
            $payment->setAmount($r->Amount);
            $payment->setCreated($r->Created);
            $payment->setParentId($r->ParentId);
            $payment->setPaymentStatusId($r->PaymentStatusId);
            $payment->setLevel($r->level);
            return $payment;
        });

        //return Payment::select('*')->where('ReceiptId','=',$this->_receipt_id)->where('uid','=',$this->_user_id)->get();
    }

    function getByIdEx($id)
    {
        $results =  \DB::select("CALL GetPaymentsByIdAndUid(?, ?)",array($id,$this->_user_id));


        return collect($results)->map(function($r){

            $payment = new Payment();
            $payment->setId($r->id);
            $payment->setUid($r->uid);
            $payment->setReceiptId($r->ReceiptId);
            $payment->setAmount($r->Amount);
            $payment->setCreated($r->Created);
            $payment->setParentId($r->ParentId);
            $payment->setPaymentStatusId($r->PaymentStatusId);
            $payment->setLevel($r->level);
            return $payment;
        });
    }

    function deleteEx($id)
    {
        $payments = $this->getByIdEx($id);
        foreach ($payments as $payment) {

                    $this->delete($this->getById($payment->getId()));
        }
        return $payments[0];
    }


    /**
     * @param $id
     * @return Eloquent
     */
    function getById($id)
    {

        return Payment::where('uid','=',$this->_user_id)->find($id);
    }

    /**
     * @return Collection
     */
    public function getAllActive()
    {
        return $this->getAll();
    }



    function getOutstandingByFlatIdAndReceiptId($flat_id,$receipt_id)
    {
        return \DB::select("SELECT GetFinDataByFlatId(f.Id,r.Month,r.Year,1) as Outstanding  FROM Flat f INNER JOIN Receipt r ON f.Id = r.FlatId AND r.Id =? WHERE f.id=?",[$receipt_id,$flat_id]);
    }

    function getOverPaidByFlatIdAndReceiptId($flat_id, $receipt_id)
    {
        return \DB::select("SELECT GetFinDataByFlatId(f.Id,r.Month,r.Year,0) as Outstanding  FROM Flat f INNER JOIN Receipt r ON f.Id = r.FlatId AND r.Id =? WHERE f.id=?",[$receipt_id,$flat_id]);
    }

    function getOutstandingByMonthAndYearAndFlatId($flat_id, $month, $year)
    {

        return \DB::select("SELECT r.Id,r.Month,r.Year, ABS(IFNULL(P.Paid,0) - r.Total) as Outstanding FROM Receipt r 	LEFT JOIN(SELECT SUM(p.Amount) as Paid, p.ReceiptId FROM Payments p GROUP BY p.ReceiptId) P ON r.Id = P.ReceiptId WHERE r.FlatId = ? AND STR_TO_DATE(CONCAT(r.Year,' ',r.Month,' ',1),'%Y %m %d') < STR_TO_DATE(CONCAT(?,' ',?,' ',1),'%Y %m %d') AND (r.StatusId =1 OR r.StatusId =3)",[$flat_id,$year,$month]);
    }

    function createOutstandingPaymentEx($receiptId, $receiptAmount, $parentPaymentId)
    {
        $payment = new Payment();
        $payment->setUid($this->_user_id);
        $payment->setReceiptId($receiptId);
        $payment->setAmount($receiptAmount);
        $payment->setCreated(time());
        $payment->setParentId($parentPaymentId);
        $payment->setPaymentStatusId(2);
        $payment->save();
        return $payment;
    }

    function getOutstandingByReceiptId($receiptId)
    {
        return \DB::select("SELECT IFNULL(SUM(IFNULL(p_out.Amount,0)),0) as Outstanding FROM Payments p 
	INNER JOIN Payments p_out ON p.Id = p_out.ParentId 
WHERE p_out.PaymentStatusId = 2 AND p.ReceiptId = ?",array($receiptId));
    }

    function getOutstandingListByReceiptId($receiptId)
    {
        return \DB::select("SELECT SUM(IFNULL(p_out.Amount,0)) as Outstanding, r.Month,r.Year FROM Payments p 
	INNER JOIN Payments p_out ON p.Id = p_out.ParentId 
	INNER JOIN Receipt r ON r.Id = p_out.ReceiptId
WHERE p_out.PaymentStatusId = 2 AND p.ReceiptId = ? GROUP BY r.Year,r.Month",array($receiptId));
    }


}