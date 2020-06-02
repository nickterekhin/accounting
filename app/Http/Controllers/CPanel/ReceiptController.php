<?php

namespace App\Http\Controllers\CPanel;

use App\Models\ModelProvider\IBuildings;
use App\Models\ModelProvider\IFlats;
use App\Models\ModelProvider\impl\Tarifes;
use App\Models\ModelProvider\IOsmd;
use App\Models\ModelProvider\IPayments;
use App\Models\ModelProvider\IReceipts;
use App\Models\ModelProvider\ITarifes;
use App\Models\Receipt;
use App\Models\Tarif;
use Exception;
use Illuminate\Http\Request;


class ReceiptController extends CPanelBaseController
{
    private $_receipt;
    private $_osmds;
    private $_buildings;
    private $_flats;
    private $_tarif;
    private $_paymants;
    public function __construct(IReceipts $receipts,IOsmd $osmd,IBuildings $buildings,IFlats $flats,ITarifes $tarif,IPayments $payments)
    {
        $this->_receipt = $receipts;
        $this->_osmds = $osmd;
        $this->_buildings = $buildings;
        $this->_flats = $flats;
        $this->_tarif = $tarif;
        $this->_paymants = $payments;
    }

    function index()
    {
        $receipt_list = $this->_receipt->getAll();
        return view('cpanel.receipts.list')->with(array('receipts_list'=>$receipt_list));
    }

    public function edit($id)
    {
        $receipt = $this->_receipt->getById($id);

        return view("cpanel.receipts.edit")->with(array("receipt"=>$receipt));
    }

    public function create(Request $request)
    {
        $flatId = $request->get('flatId');
        $params = array();
        if(!$flatId) {
            $buildings = $this->_buildings->getAllActive();
            $osmds = $this->_osmds->getAllActive();
            $flats = $this->_flats->getAllActiveWithoutOwner();
            $params['buildings']=$buildings;
            $params['osmds']=$osmds;
            $params['flats']=$flats;
        }else
        {
            $flat = $this->_flats->getById($flatId);
            $params['flat']=$flat;
            $params['flatId']=$flatId;
        }
        return view('cpanel.receipts.add')->with($params);
    }

    public function store(Request $request)
    {
        /** @var Tarif $tarif */
        $tarif = $this->_tarif->getActiveOne();
        try{

            /** @var Receipt $receipt */
            $receipt = $this->_receipt->initModel($request->get('Flat'),$tarif->getId(),$request->get('Month'));
        }catch(Exception $ex)
        {
            return view('receipt.add')->with($this->ShowMessage("Error:".$ex->getMessage(),"alert-danger"));
        }

        return \Redirect::route('receipt');
    }

    public function openClose($active,$id)
    {

        /** @var Receipt $receipt */
        $receipt = $this->_receipt->getById($id);

        switch ($active) {
            case 'open':
                $receipt->setActive(1);
                break;
            case 'close':
                $receipt->setActive(0);
                break;

        }
        $this->_receipt->update($receipt);
        return \Redirect::route('sub.receipt.all',array('id'=>$receipt->Flat->getId()));
    }

    function destroy($id)
    {
        /** @var Receipt $receipt */
        $receipt = $this->_receipt->getById($id);
        try {
            \DB::beginTransaction();
            foreach ($receipt->Payments as $p) {
                $this->_paymants->deleteEx($p->getId());
            }
            $this->_flats->delete($receipt);
            \DB::commit();
        }catch(Exception $ex)
        {
            return \Redirect::route('sub.receipt.all',array("id"=>$receipt->Flat->getId()))->with($this->ShowMessage("Error:".$ex->getMessage(),"alert-danger"));
        }

        return \Redirect::route('sub.receipt.all',array('id'=>$receipt->Flat->getId()));
    }

    function view_receipt($id)
    {
        /** @var Receipt $receipt */
        $receipt = $this->_receipt->getById($id);
        $building = $this->_buildings->getById($receipt->Flat->Building->getId());
        if($receipt->getStatusId()==2)
        {
            var_dump($this->_paymants->getOutstandingByFlatIdAndReceiptId($receipt->Flat->getId(),$receipt->getId()));
            $receipt->setOutstanding($this->_paymants->getOutstandingByFlatIdAndReceiptId($receipt->Flat->getId(),$receipt->getId())[0]->Outstanding);
            $receipt->setOutstandingList($this->_paymants->getOutstandingListByReceiptId($receipt->getId()));
        }

       
        return view('cpanel.receipts.view')->with(array('receipt'=>$receipt,'building'=>$building,'hideManageButtons'=>true));
    }


    //--------------------------Payments--------------------------------

    public function payments(Request $request,$id,$action,$payment_id=0)
    {
        $receipt = $this->_receipt->getById($id);
        $this->_paymants->setReceiptId($id);
        switch ($action)
        {
            case 'all':
                $payments = $this->_paymants->getAll();
                return view('cpanel.payments.list')->with(array('payments'=>$payments,'receipt'=>$receipt));
                break;
            case 'add':
                break;
            case 'del':
                break;
        }


    }
    //---------------------------------Receipt----------------------------------
    public function receipt_all(Request $request,$id,$obj_id=null)
    {
        $flat = $this->_flats->getById($id);

                $receipts_list = $this->_receipt->getAllByFlatId($id);
                return view('cpanel.receipts.list')->with(array('receipts_list'=>$receipts_list,'flat'=>$flat));
    }

    public function receipt_add(Request $request,$id,$obj_id=null)
    {

    }
    public function receipt_add_post(Request $request,$id,$obj_id=null)
    {
        /** @var Tarif $tarif */
        $tarif = $this->_tarif->getActiveOne();
        try{
            /** @var Receipt $receipt */
            $receipt = $this->_receipt->initModel($id,$tarif->getId(),$request->get("Month"));
        }catch(Exception $ex)
        {
            return \Redirect::route('sub.receipt.all',array("id"=>$id))->with($this->ShowMessage("Error:".$ex->getMessage(),"alert-danger"));
        }

        return \Redirect::route('sub.receipt.all',array('id'=>$id));
    }
    public function receipt_view(Request $request,$id,$obj_id=null)
    {

    }


}
