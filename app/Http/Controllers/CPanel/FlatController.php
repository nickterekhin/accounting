<?php

namespace App\Http\Controllers\CPanel;

use App\Models\Flat;
use App\Models\FlatView;
use App\Models\ModelProvider\IBuildings;
use App\Models\ModelProvider\IFlats;
use App\Models\ModelProvider\IFlatsViews;
use App\Models\ModelProvider\impl\FlatsViews;
use App\Models\ModelProvider\IOsmd;
use App\Models\ModelProvider\IReceipts;
use App\Models\ModelProvider\ITarifes;
use App\Models\Receipt;
use App\Models\Tarif;
use Exception;
use Illuminate\Http\Request;

class FlatController extends CPanelBaseController
{
    private $_flats;
    private $_buildings;
    private $_osmds;
    private $_tarif;
    private $_receipt;
    private $_flatView;
    private  $rules = array(
        'Number'=>'required',
        'Building'=>'required',
        'Level'=>'required',
        'Section'=>'required',
        'Square'=>'required',
        'PublicAccount'=>'required',
        'People'=>'required'
    );
    function __construct(IFlats $flats,IBuildings $buildings,IOsmd $osmd,ITarifes $tarifes, IReceipts $receipts,IFlatsViews $flatsViews)
    {
        $this->_flats = $flats;
        $this->_buildings = $buildings;
        $this->_osmds = $osmd;
        $this->_tarif = $tarifes;
        $this->_receipt = $receipts;
        $this->_flatView = $flatsViews;
    }

    function index()
    {
        //$flats_list = $this->_flats->getAll();

        $flats_list = $this->_flatView->getAll();
       // var_dump($flats[0]->getFinState());
        return view('cpanel.flats.list')->with(array('flats_list'=>$flats_list));
    }

    function create(Request $request)
    {

        $buildingId = $request->get('building');
        $params = array();
        if(!$buildingId) {
            $buildings = $this->_buildings->getAllActive();
            $osmds = $this->_osmds->getAllActive();
            $params['buildings']=$buildings;
            $params['osmds']=$osmds;
        }else
        {
            $building = $this->_buildings->getById($buildingId);
            $params['building']=$building;
            $params['buildingId']=$buildingId;
        }

        return view('cpanel.flats.add')->with($params);
    }

    function store(Request $request)
    {
        $validator = \Validator::make($request->all(),$this->rules);

        if($validator->fails())
        {
            return \Redirect::route('flats.create')->withInput()->withErrors($validator);
        }else
        {
            $active    = $request->get( 'Active' );
            $active    = ( isset( $active ) && $active == '1' ) ? true : false;

            $options   = array(
                'BuildingId'=>$request->get('Building'),
                'Number'=>$request->get("Number"),
                'Level'=>$request->get('Level'),
                'Section'   => $request->get('Section'),
                'Square'   => $request->get('Square'),
                'People' => $request->get('People'),
                'PublicAccount'=>$request->get('PublicAccount'),
                'Active'    => $active

            );
            try {
                $this->_flats->create($options);
            }catch(Exception $ex)
            {
                return \Redirect::route( 'flats.create' )->withInput()->with( $this->ShowMessage( 'Flat added Error:'.$ex->getMessage(), 'alert-danger' ) );
            }
            return \Redirect::route( 'flats.create' )->with( $this->ShowMessage( 'Flat added. Life is good.', 'alert-success' ) );
        }
    }
    function edit($id)
    {
        $flat = $this->_flats->getById($id);

        $osmds = $this->_osmds->getAllActive();

        $params['osmds']=$osmds;

        return view('cpanel.flats.edit')->with(array('flat'=>$flat,'osmds'=>$osmds));
    }

    function update(Request $request,$id)
    {
        $validator = \Validator::make($request->all(),$this->rules);

        if($validator->fails())
        {
            return \Redirect::route('flats.edit',array('id'=>$id))->withInput()->withErrors($validator);
        }else
        {
            $active    = $request->get( 'Active' );
            $active    = ( isset( $active ) && $active == '1' ) ? true : false;

            /** @var Flat $flat */
            $flat = $this->_flats->getById($id);
            $flat->setBuildingId($request->get('Building'));
            $flat->setNumber($request->get('Number'));
            $flat->setLevel($request->get('Level'));
            $flat->setSection($request->get('Section'));
            $flat->setSquare($request->get('Square'));
            $flat->setPeople($request->get('People'));
            $flat->setPublicAccount($request->get('PublicAccount'));
            $flat->setActive($active);

            try {
                $this->_flats->update($flat);
            }catch(Exception $ex)
            {
                return \Redirect::route( 'flats.edit',array('id'=>$id) )->withInput()->with( $this->ShowMessage( 'Flat updated Error:'.$ex->getMessage(), 'alert-danger' ) );
            }
            return \Redirect::route( 'flats.edit' ,array('id'=>$id))->with( $this->ShowMessage( 'Flat updated. Life is good.', 'alert-success' ) );
        }
    }
    function destroy($id)
    {
        /** @var Flat $flat */
        $flat = $this->_flats->getById($id);
        $this->_flats->delete($flat);

        return \Redirect::route('sub.flat.all',array('id'=>$flat->Building->getId()));
    }

    public function openClose($active,$id)
    {
        /** @var Flat $flat */
        $flat = $this->_flats->getById($id);

        switch ($active) {
            case 'open':
                $flat->setActive(1);
                break;
            case 'close':
                $flat->setActive(0);
                break;

        }
        $this->_flats->update($flat);
        return \Redirect::route('sub.flat.all',array('id'=>$flat->Building->getId()));
    }

    public function receipt(Request $request,$id,$action,$receipt_id=0)
    {

        $flat = $this->_flats->getById($id);
        switch($action)
        {
            case 'all':
                $receipts_list = $this->_receipt->getAllByFlatId($id);
                return view('cpanel.receipts.list')->with(array('receipts_list'=>$receipts_list,'flat'=>$flat));
                break;
        }

        /** @var Tarif $tarif */
        $tarif = $this->_tarif->getActiveOne();
        try{
        /** @var Receipt $receipt */
        $receipt = $this->_receipt->initModel($id,$tarif->getId());
        }catch(Exception $ex)
        {
            return \Redirect::route('flats')->with($this->ShowMessage("Error:".$ex->getMessage(),"alert-danger"));
        }

        return \Redirect::route('cpanel.receipt.edit',array('id'=>$receipt->getId()));
    }

    public function receiptShowAll(Request $request,$id)
    {
        $receipts = $this->_receipt->getAllByFlatId($id);
        
    }

    //------------------------Flat----------------------------
    function flat_all(Request $request,$id,$obj_id=null)
    {
        $building = $this->_buildings->getById($id);
        $flats_list = $this->_flats->getByBuildingId($id);
        return view('cpanel.flats.list')->with(array('flats_list'=>$flats_list,'building'=>$building));
    }

    function flat_add(Request $request,$id,$obj_id=null)
    {
        $building = $this->_buildings->getById($id);
        return view('cpanel.flats.add')->with(array('building'=>$building));
    }
    function flat_add_post(Request $request,$id,$obj_id=null)
    {
        $validator = \Validator::make($request->all(),$this->rules);

        if($validator->fails())
        {
            return \Redirect::route('sub.flat.add',array('id'=>$id))->withInput()->withErrors($validator);
        }else
        {
            $active    = $request->get( 'Active' );
            $active    = ( isset( $active ) && $active == '1' ) ? true : false;

            $options   = array(
                'BuildingId'=>$request->get('Building'),
                'Number'=>$request->get("Number"),
                'Level'=>$request->get('Level'),
                'Section'   => $request->get('Section'),
                'Square'   => $request->get('Square'),
                'People' => $request->get('People'),
                'PublicAccount'=>$request->get('PublicAccount'),
                'Active'    => $active

            );
            try {
                $this->_flats->create($options);
            }catch(Exception $ex)
            {
                return \Redirect::route( 'sub.flat.add',array('id'=>$id) )->withInput()->with( $this->ShowMessage( 'Flat added Error:'.$ex->getMessage(), 'alert-danger' ) );
            }
            return \Redirect::route( 'sub.flat.add',array('id'=>$id) )->with( $this->ShowMessage( 'Flat added. Life is good.', 'alert-success' ) );
        }
    }


    function flat_edit(Request $request,$id,$obj_id=null)
    {

        $building = $this->_buildings->getById($id);

        $flat = $this->_flats->getById($obj_id);


        return View('cpanel.flats.edit')->with(array('building'=>$building,'flat'=>$flat));
    }
    function flat_edit_post(Request $request,$id,$obj_id=null)
    {
        $validator = \Validator::make($request->all(),$this->rules);

        if($validator->fails())
        {
            return \Redirect::route('sub.flat.edit',array('id'=>$request->get('Building'),'obj_id'=>$obj_id))->withInput()->withErrors($validator);
        }else
        {
            $active    = $request->get( 'Active' );
            $active    = ( isset( $active ) && $active == '1' ) ? true : false;

            /** @var Flat $flat */
            $flat = $this->_flats->getById($obj_id);
            $flat->setBuildingId($request->get('Building'));
            $flat->setNumber($request->get('Number'));
            $flat->setLevel($request->get('Level'));
            $flat->setSection($request->get('Section'));
            $flat->setSquare($request->get('Square'));
            $flat->setPeople($request->get('People'));
            $flat->setPublicAccount($request->get('PublicAccount'));
            $flat->setActive($active);

            try {
                $this->_flats->update($flat);
            }catch(Exception $ex)
            {
                return \Redirect::route( 'sub.flat.edit',array('id'=>$request->get('Building'),'obj_id'=>$obj_id) )->withInput()->with( $this->ShowMessage( 'Flat updated Error:'.$ex->getMessage(), 'alert-danger' ) );
            }
            return \Redirect::route( 'sub.flat.edit' ,array('id'=>$request->get('Building'),'obj_id'=>$obj_id))->with( $this->ShowMessage( 'Flat updated. Life is good.', 'alert-success' ) );
        }
    }
}

