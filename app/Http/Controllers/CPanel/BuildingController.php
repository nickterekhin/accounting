<?php

namespace App\Http\Controllers\CPanel;

use App\Models\Address;
use App\Models\Building;
use App\Models\ModelProvider\IAddresses;
use App\Models\ModelProvider\IAddressTypes;
use App\Models\ModelProvider\IBuildings;
use App\Models\ModelProvider\IFlats;
use App\Models\ModelProvider\IOsmd;
use Exception;
use Illuminate\Http\Request;

class BuildingController extends CPanelBaseController
{

    private $_buildings;
    private $_osmd;
    private $_flats;
    private  $rules = array(
        'Title'=>'required',
        'Levels'=>'required',
        'City'=>'required',
        'Street1'=>'required',
        'ZipCode'=>'required',

    );

    function __construct(IBuildings $buildings,IOsmd $osmd, IAddressTypes $addressTypes,IAddresses $addresses,IFlats $flats)
    {
        $this->_buildings = $buildings;
        $this->_osmd = $osmd;
        $this->_address = $addresses;
        $this->_address_types = $addressTypes;
        $this->_flats = $flats;
    }

    function index()
    {
        $buildings = $this->_buildings->getAll();
        return View('cpanel.building.list')->with(array('buildings'=>$buildings));
    }

    function create()
    {
        $osmd_list = $this->_osmd->getAllActive();
        return View('cpanel.building.add')->with(array('osmd_list'=>$osmd_list));
    }
    function store(Request $request)
    {
        $validator = \Validator::make($request->all(),$this->rules);

        if($validator->fails())
        {
            return \Redirect::route('building.create')->withInput()->withErrors($validator);
        }else
        {
            $active    = $request->get( 'Active' );
            $active    = ( isset( $active ) && $active == '1' ) ? true : false;

            $options   = array(
                'OsmdId'=>$request->get('OSMD'),
                'Title'=>$request->get("Title"),
                'Slug'=>$this->createSlug($request->get("Title")),
                'Levels'   => $request->get('Level'),
                'Active'    => $active

            );
            try{
                \DB::beginTransaction();
                /** @var Building $o */
                $o = $this->_buildings->create($options);
                $this->saveAddress($request,'Building',$o->getId());
                \DB::commit();
            }catch (Exception $ex)
            {
                \DB::rollBack();

                return \Redirect::route( 'building.add' )->withInput()->with( $this->ShowMessage( 'Building added Error:'.$ex->getMessage(), 'alert-danger' ) );
            }



            return \Redirect::route( 'building.add' )->with( $this->ShowMessage( 'Building added. Life is good.', 'alert-success' ) );
        }
    }
    function edit($id)
    {
        $building = $this->_buildings->getById($id);
        return view("cpanel.building.edit")->with(array('building'=>$building));
    }

    function update(Request $request,$id)
    {
        $validator = \Validator::make($request->all(),$this->rules);

        if($validator->fails())
        {
            return \Redirect::route('building.edit' ,array('id'=>$id))->withInput()->withErrors($validator);
        }else
        {
            $active    = $request->get( 'Active' );
            $active    = ( isset( $active ) && $active == '1' ) ? true : false;

            /** @var Building $building */
            $building = $this->_buildings->getById($id);
            $building->setOsmdId($request->get("OSMD"));
            $building->setTitle($request->get("Title"));
            $building->setSlug($this->createSlug($request->get("Title")));
            $building->setLevels($request->get("Levels"));
            $building->setActive($active);

            try{
                \DB::beginTransaction();
                $this->_buildings->update($building);
                $this->updateAddress($request,'Building',$id);
                \DB::commit();
            }catch(Exception $ex)
            {
                \DB::rollBack();
                return \Redirect::route( 'building.edit' ,array('id'=>$id) )->with( $this->ShowMessage( 'Building edit. Error:'.$ex->getMessage(), 'alert-danger' ) );
            }


            return \Redirect::route( 'osmd.building.all' ,array('id'=>$id) )->with( $this->ShowMessage( 'Building updated. Life is good.', 'alert-success' ) );
        }
    }
    function destroy($id)
    {
        /** @var Building $building */
        $building = $this->_buildings->getById($id);
        $osmd_id = $building->Osmd->getId();
        /** @var Address $address */
        $address = $this->_address->getByTypeNameAndObjectId('Building',$building->getId());

        try{
            \DB::beginTransaction();
            $this->_buildings->delete($building);
            $this->_address->delete($address);
            \DB::commit();
        }catch (Exception $ex)
        {
            \DB::rollBack();
        }

        return \Redirect::route('sub.building.all',array('id'=>$osmd_id));
    }

    public function openClose($active,$id)
    {
        /** @var Building $building */
        $building = $this->_buildings->getById($id);
        switch ($active) {
            case 'open':
                $building->setActive(1);
                break;
            case 'close':
                $building->setActive(0);
                break;

        }
        $this->_buildings->update($building);
        return \Redirect::route('sub.building.all',array('id'=>$building->Osmd->getId()));
    }

    public function flat(Request $request,$id,$action,$obj_id=null)
    {

        $building = $this->_buildings->getById($id);
        switch($action)
        {
            case'all':
                $flats_list = $this->_flats->getByBuildingId($id);
                return view('cpanel.flats.list')->with(array('flats_list'=>$flats_list,'building'=>$building));
                break;
            case 'add':
                return View('cpanel.flats.add')->with(array('building'=>$building));
                break;
        }
        return \Redirect::route('sub.building.all');
    }

    //------------------------Bulding -------------------------
    public function building_all(Request $request,$id,$obj_id=null)
    {
        $osmd = $this->_osmd->getById($id);
        $buildings_list = $this->_buildings->getByOsmdId($id);
        return view('cpanel.building.list')->with(array('buildings'=>$buildings_list,'osmd'=>$osmd));
    }
    public function building_add(Request $request,$id,$obj_id=null)
    {
        $osmd = $this->_osmd->getById($id);
        return View('cpanel.building.add')->with(array('osmd'=>$osmd));
    }
    public function building_add_post(Request $request,$id,$obj_id=null)
    {
        //$osmd = $this->_osmd->getById($id);

        $validator = \Validator::make($request->all(),$this->rules);

        if($validator->fails())
        {
            return \Redirect::route('sub.building.add',array('id'=>$request->get('OSMD')))->withInput()->withErrors($validator);
        }else
        {
            $active    = $request->get( 'Active' );
            $active    = ( isset( $active ) && $active == '1' ) ? true : false;

            $options   = array(
                'OsmdId'=>$request->get('OSMD'),
                'Title'=>$request->get("Title"),
                'Slug'=>$this->createSlug($request->get("Title")),
                'Levels'   => $request->get('Levels'),
                'Active'    => $active

            );
            try{
                \DB::beginTransaction();
                /** @var Building $o */
                $o = $this->_buildings->create($options);
                $this->saveAddress($request,'Building',$o->getId());
                \DB::commit();
            }catch (Exception $ex)
            {
                \DB::rollBack();

                return \Redirect::route( 'sub.building.add',array('id'=>$request->get('OSMD')) )->withInput()->with( $this->ShowMessage( 'Building added Error:'.$ex->getMessage(), 'alert-danger' ) );
            }



            return \Redirect::route( 'sub.building.add',array('id'=>$request->get('OSMD')) )->with( $this->ShowMessage( 'Building added. Life is good.', 'alert-success' ) );
        }
    }

    public function building_edit(Request $request,$id,$obj_id=null)
    {
        $building = $this->_buildings->getById($obj_id);
        return view("cpanel.building.edit")->with(array('building'=>$building));
    }
    public function building_edit_post(Request $request,$id,$obj_id=null)
    {
        $validator = \Validator::make($request->all(),$this->rules);

        if($validator->fails())
        {
            return \Redirect::route('sub.building.edit' ,array('id'=>$request->get("OSMD"),'obj_id'=>$obj_id))->withInput()->withErrors($validator);
        }else
        {
            $active    = $request->get( 'Active' );
            $active    = ( isset( $active ) && $active == '1' ) ? true : false;

            /** @var Building $building */
            $building = $this->_buildings->getById($obj_id);
            $building->setOsmdId($request->get("OSMD"));
            $building->setTitle($request->get("Title"));
            $building->setSlug($this->createSlug($request->get("Title")));
            $building->setLevels($request->get("Levels"));
            $building->setActive($active);

            try{
                \DB::beginTransaction();
                $this->_buildings->update($building);
                $this->updateAddress($request,'Building',$id);
                \DB::commit();
            }catch(Exception $ex)
            {
                \DB::rollBack();
                return \Redirect::route( 'sub.building.edit' ,array('id'=>$request->get("OSMD"),'obj_id'=>$obj_id) )->with( $this->ShowMessage( 'Building edit. Error:'.$ex->getMessage(), 'alert-danger' ) );
            }


            return \Redirect::route( 'sub.building.edit' ,array('id'=>$request->get("OSMD"),'obj_id'=>$obj_id) )->with( $this->ShowMessage( 'Building updated. Life is good.', 'alert-success' ) );
        }
    }
    //--------------
}
