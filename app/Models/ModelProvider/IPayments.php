<?php


namespace App\Models\ModelProvider;


interface IPayments extends IBaseModel
{
    function setReceiptId($receipt_id);
    function getByIdEx($id);
    function deleteEx($id);
    function getOutstandingByFlatIdAndReceiptId($flat_id,$receipt_id);
    function getOutstandingByMonthAndYearAndFlatId($flat_id,$month,$year);
    function getOverPaidByFlatIdAndReceiptId($flat_id,$receipt_id);
    function createOutstandingPaymentEx($receiptId,$receiptAmount,$parentPaymentId);
    function getOutstandingByReceiptId($receiptId);
    function getOutstandingListByReceiptId($receiptId);
}