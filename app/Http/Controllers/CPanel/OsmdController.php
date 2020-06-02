<?php

namespace App\Http\Controllers\CPanel;

use App\Dobby\Dobby;
use App\Models\Address;
use App\Models\ModelProvider\IAddresses;
use App\Models\ModelProvider\IAddressTypes;
use App\Models\ModelProvider\IBanks;
use App\Models\ModelProvider\IBuildings;
use App\Models\ModelProvider\IOsmd;
use App\Models\Osmd;
use Exception;
use Illuminate\Http\Request;

class OsmdController extends CPanelBaseController
{
    /**
     * @var IOsmd
     */
    private $_osmd;
    private $_banks;
    private $_buildings;
    private  $rules = array(
        'Title'=>'required',
        'okpo'=>'required',
        'Bank'=>'required',
        'City'=>'required',
        'Street1'=>'required',
        'ZipCode'=>'required',
        'Account'=>'required'

    );
    function __construct(IOsmd $osmd,IBanks $banks,IAddressTypes $addressTypes, IAddresses $addresses,IBuildings $buildings)
    {
        $this->_osmd = $osmd;
        $this->_banks = $banks;
        $this->_address = $addresses;
        $this->_address_types = $addressTypes;
        $this->_buildings = $buildings;
    }
    function index()
    {

        $osmd_list = $this->_osmd->getAll();

        return view('cpanel.osmd.list')->with(array('osmd_list'=>$osmd_list));
    }
    public function create()
    {
        $banks = $this->_banks->getAllActive();
        return view("cpanel.osmd.add")->with(array('banks'=>$banks));
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(),$this->rules);

        if($validator->fails())
        {
            return \Redirect::route('osmd.create')->withInput()->withErrors($validator);
        }else
        {
            $active    = $request->get( 'Active' );
            $active    = ( isset( $active ) && $active == '1' ) ? true : false;


            $options   = array(
                'Title'=>$request->get("Title"),
                'Slug'=>$this->createSlug($request->get("Title")),
                'Okpo'   => $request->get('okpo'),
                'BankId'=>$request->get("Bank"),
                'Active'    => $active,
                'Account'=>$request->get('Account'),
                'AddedAt'=>time()

            );
            try{
                \DB::beginTransaction();
                /** @var Osmd $o */
                $o = $this->_osmd->create($options);
                $this->saveAddress($request,'Osmd',$o->getId());
                \DB::commit();
            }catch (Exception $ex)
            {
                \DB::rollBack();

                return \Redirect::route( 'osmd.create' )->withInput()->with( $this->ShowMessage( 'Osmd added Error:'.$ex->getMessage(), 'alert-danger' ) );
            }



            return \Redirect::route( 'osmd.create' )->with( $this->ShowMessage( 'OSMD added. Life is good.', 'alert-success' ) );
        }
    }

    function edit($id)
    {
        $osmd = $this->_osmd->getById($id);
        $banks = $this->_banks->getAllActive();
        return view("cpanel.osmd.edit")->with(array('osmd'=>$osmd,'banks'=>$banks));
    }

    function update(Request $request,$id)
    {
        $validator = \Validator::make($request->all(),$this->rules);

        if($validator->fails())
        {
            return \Redirect::route('osmd.edit' ,array('id'=>$id))->withInput()->withErrors($validator);
        }else
        {
            $active    = $request->get( 'Active' );
            $active    = ( isset( $active ) && $active == '1' ) ? true : false;

            /** @var Osmd $osmd */
            $osmd = $this->_osmd->getById($id);
            $osmd->setTitle($request->get("Title"));
            $osmd->setSlug($this->createSlug($request->get("Title")));
            $osmd->setOkpo($request->get("okpo"));
            $osmd->setBankId($request->get("Bank"));
            $osmd->setAccount($request->get("Account"));
            $osmd->setActive($active);

            try{
                \DB::beginTransaction();
                $this->_osmd->update($osmd);
                $this->updateAddress($request,'Osmd',$id);
                \DB::commit();
            }catch(Exception $ex)
            {
                \DB::rollBack();
                return \Redirect::route( 'osmd.edit' ,array('id'=>$id) )->with( $this->ShowMessage( 'OSMD edit. Error:'.$ex->getMessage(), 'alert-danger' ) );
            }


            return \Redirect::route( 'osmd.edit' ,array('id'=>$id) )->with( $this->ShowMessage( 'OSMD updated. Life is good.', 'alert-success' ) );
        }
    }
    function destroy($id)
    {
        /** @var Osmd $osmd */
        $osmd = $this->_osmd->getById($id);
        /** @var Address $address */
        $address = $this->_address->getByTypeNameAndObjectId('Osmd',$osmd->getId());
        try{
            \DB::beginTransaction();
            $this->_osmd->delete($osmd);
            $this->_address->delete($address);
            \DB::commit();
        }catch (Exception $ex)
        {
            \DB::rollBack();
        }


        return \Redirect::route('osmd');
    }

    public function openClose($active,$id)
    {
        /** @var Osmd $osmd */
        $osmd = $this->_osmd->getById($id);
        switch ($active) {
            case 'open':
                $osmd->setActive(1);
                break;
            case 'close':
                $osmd->setActive(0);
                break;

        }
        $this->_osmd->update($osmd);
        return \Redirect::route('osmd');
    }

    /*public function building(Request $request,$id,$action,$obj_id=null)
    {

        $osmd = $this->_osmd->getById($id);
        switch($action)
        {
            case'all':
                $buildings_list = $this->_buildings->getByOsmdId($id);
                return view('cpanel.building.list')->with(array('buildings'=>$buildings_list,'osmd'=>$osmd));
                break;
            case 'add':
                return View('cpanel.building.add')->with(array('osmd'=>$osmd));
                break;
        }
        return \Redirect::route('osmd');
    }*/
}
