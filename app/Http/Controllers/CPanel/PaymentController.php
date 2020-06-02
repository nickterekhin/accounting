<?php

namespace App\Http\Controllers\CPanel;

use App\Models\ModelProvider\IPayments;
use App\Models\ModelProvider\IReceipts;
use App\Models\Payment;
use App\Models\Receipt;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    private $_receipt;

    private $_paymants;
    public function __construct(IReceipts $receipts,IPayments $payments)
    {
        $this->_receipt = $receipts;
        $this->_paymants = $payments;
    }
    function destroy($id)
    {
        /** @var Payment $p */
        $p = $this->_paymants->getById($id);
        try {
            \DB::beginTransaction();
            $this->_paymants->deleteEx($id);
            \DB::commit();
            return \Redirect::route('sub.payment.all',array('id'=>$p->Receipt->getId()));
        }catch(Exception $ex)
        {
            \DB::rollBack();
            return \Redirect::route('sub.payment.all',array("id"=>$p->Receipt->getId()))->with($this->ShowMessage("Error:".$ex->getMessage(),"alert-danger"));
        }

    }

   function payment_all(Request $request,$id,$obj_id=null)
   {
       /** @var Receipt $receipt */
       $receipt = $this->_receipt->getById($id);
       $outstanding = $this->_paymants->getOutstandingByFlatIdAndReceiptId($receipt->getFlatId(),$id);
       $overpaid = $this->_paymants->getOverPaidByFlatIdAndReceiptId($receipt->getFlatId(),$id);
       $list_of_outstanding = $this->_paymants->getOutstandingByMonthAndYearAndFlatId($receipt->getFlatId(),$receipt->getMonth(),$receipt->getYear());

       $receipt->setOutstanding($outstanding[0]->Outstanding??0);
       $receipt->setOverpaid($overpaid[0]->Outstanding??0);

       $this->_paymants->setReceiptId($id);
       $payments = $this->_paymants->getAll();
       return view('cpanel.payments.list')->with(array('payments'=>$payments,'receipt'=>$receipt,'list_of_outstanding'=>$list_of_outstanding,'hideManageButtons'=>true));
   }

    function payment_add_post(Request $request,$id,$obj_id=null)
    {
       try {
           /** @var Receipt $receipt */
           $receipt = $this->_receipt->getById($id);
           $amount = $request->get("Amount");
           $res = $amount-$receipt->getTotal();
           $options = array(
                'Amount'=>$request->get('Amount'),
               'ReceiptId' => $id,
               'Created' => time()
           );

           if($res>0)
           {
               $options_over_paid = $options;
               $options['Amount'] = $amount-$res;
               $options_over_paid['Amount'] = $res;
               $options_over_paid['PaymentStatusId']=3;
           }


           \DB::beginTransaction();
           /** @var Payment $new_payment */
           $new_payment =  $this->_paymants->create($options);
           if(isset($options_over_paid))
           {
                $options_over_paid['ParentId'] = $new_payment->getId();
                $this->_paymants->create($options_over_paid);
           }
           $outstanding = $request->get("outstanding");
          if(isset($outstanding))
          {
              foreach($outstanding as $k=>$o)
              {
                  $this->_paymants->createOutstandingPaymentEx($k,$o,$new_payment->getId());
              }
          }
          \DB::commit();
       }catch(Exception $ex)
       {
           \DB::rollBack();
           return \Redirect::route('sub.payment.all',array("id"=>$id))->with($this->ShowMessage("Error:".$ex->getMessage(),"alert-danger"));
       }

        return \Redirect::route('sub.payment.all',array('id'=>$id));
    }

}
