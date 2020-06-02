<?php

namespace App\Http\Controllers\CPanel;


use App\Models\Address;
use App\Models\AddressType;
use App\Models\Bank;
use App\Models\ModelProvider\IAddresses;
use App\Models\ModelProvider\IAddressTypes;
use App\Models\ModelProvider\IBanks;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class BankController extends CPanelBaseController
{
    /**
     * @var IBanks
     */
    private $_banks;

    private  $rules = array(
        'BankTitle'=>'required',
        'mfo'=>'required',
        'City'=>'required',
        'Street1'=>'required',
        'ZipCode'=>'required',

    );
    function __construct(IBanks $banks,IAddresses $addresses,IAddressTypes $addressTypes)
    {
        $this->_banks = $banks;
        $this->_address = $addresses;
        $this->_address_types = $addressTypes;
    }

    function index()
    {
        $banks = $this->_banks->getAll();


        return view('cpanel.banks.list')->with(array('banks'=>$banks));
    }
    function create()
    {
        return view('cpanel.banks.add');
    }
    function store(Request $request)
    {

        $validator = \Validator::make($request->all(),$this->rules);

        if($validator->fails())
        {
            return \Redirect::route('bank.create')->withInput()->withErrors($validator);
        }else
        {
            $active    = $request->get( 'Active' );
            $active    = ( isset( $active ) && $active == '1' ) ? true : false;

            $options   = array(
                'Title'=>$request->get("BankTitle"),
                'Slug'=>$this->createSlug($request->get("BankTitle")),
                'mfo'   => $request->get('mfo'),
                'Active'    => $active

            );

            try{
                \DB::beginTransaction();
                /** @var Bank $b */
                $b = $this->_banks->create($options);
                $this->saveAddress($request,'Bank',$b->getId());

                \DB::commit();
            }catch (Exception $e)
            {

                    \DB::rollBack();

                return \Redirect::route( 'bank.create' )->withInput()->with( $this->ShowMessage( 'Bank added Error:'.$e->getMessage(), 'alert-danger' ) );
            }


            return \Redirect::route( 'bank.create' )->with( $this->ShowMessage( 'Bank added. Life is good.', 'alert-success' ) );
        }
    }
    function edit($id)
    {
        $bank = $this->_banks->getById($id);
        return view('cpanel.banks.edit')->with(array('bank'=>$bank));
    }

    function update(Request $request,$id)
    {
        $validator = \Validator::make($request->all(),$this->rules);

        if($validator->fails())
        {
            return \Redirect::route('bank.create',array('id'=>$id))->withInput()->withErrors($validator);
        }else
        {
            $active    = $request->get( 'Active' );
            $active    = ( isset( $active ) && $active == '1' ) ? true : false;

            /** @var Bank $bank */
            $bank = $this->_banks->getById($id);



            $bank->setTitle($request->get("BankTitle"));
            $bank->setSlug($this->createSlug($request->get("BankTitle")));
            $bank->setMfo($request->get('mfo'));
            $bank->setActive($active);



            try {
                \DB::beginTransaction();
                $this->_banks->update($bank);
                $this->updateAddress($request,'Bank',$id);
                \DB::commit();

            }catch(Exception $ex)
            {
                \DB::rollBack();
                return \Redirect::route( 'bank.edit' ,array('id'=>$id))->withInput()->with( $this->ShowMessage( 'Bank updated Error: '.$ex->getMessage(), 'alert-danger' ) );
            }

            return \Redirect::route( 'bank.edit' ,array('id'=>$id))->with( $this->ShowMessage( 'Bank updated. Life is good.', 'alert-success' ) );
        }
    }

    function destroy($id)
    {
        /** @var Bank $bank */
        $bank = $this->_banks->getById($id);
        /** @var Address $address */
        $address = $this->_address->getByTypeNameAndObjectId('Bank',$bank->getId());
        try{
            \DB::beginTransaction();
            $this->_banks->delete($bank);
            $this->_address->delete($address);
        }catch (Exception $ex)
        {
            \DB::rollBack();
        }

        return \Redirect::route('bank');
    }

    public function openClose($active,$id)
    {
        /** @var Bank $bank */
        $bank = $this->_banks->getById($id);
        switch ($active) {
            case 'open':
                $bank->setActive(1);
                break;
            case 'close':
                $bank->setActive(0);
                break;

        }
        $this->_banks->update($bank);
        return \Redirect::route('bank');
    }
}
