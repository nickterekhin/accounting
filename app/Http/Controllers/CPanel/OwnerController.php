<?php

namespace App\Http\Controllers\CPanel;

use App\Models\Flat;
use App\Models\ModelProvider\IBuildings;
use App\Models\ModelProvider\IFlats;
use App\Models\ModelProvider\IOsmd;
use App\Models\ModelProvider\IOwners;
use App\Models\Owner;
use Exception;
use Illuminate\Http\Request;


class OwnerController extends CPanelBaseController
{

    private $_owners;
    private $_osmds;
    private $_buildings;
    private $_flats;
    private $rules = array(
        'Flat'=>'required',
        'FirstName'=>'required',
        'LastName'=>'required'
    );

    /**
     *
     * OwnerController constructor.
     * @param IOwners $owners
     * @param IOsmd $osmd
     * @param IBuildings $buildings
     * @param IFlats $flats
     */
    public function __construct(IOwners $owners,IOsmd $osmd,IBuildings $buildings,IFlats $flats)
    {
        $this->_owners = $owners;
        $this->_osmds = $osmd;
        $this->_buildings = $buildings;
        $this->_flats = $flats;
    }

    public function index()
    {
        $owners = $this->_owners->getAllActive();
        return view('cpanel.owners.list')->with(array('owners'=>$owners));
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

        return view('cpanel.owners.add')->with($params);
    }
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(),$this->rules);

        if($validator->fails())
        {
            return \Redirect::route('owner.create')->withInput()->withErrors($validator);
        }else
        {
            $active    = $request->get( 'Active' );
            $active    = ( isset( $active ) && $active == '1' ) ? true : false;


            $options   = array(
                'FlatId'=>$request->get('Flat'),
                'FirstName'=>$request->get("FirstName"),
                'LastName'=>$request->get('LastName'),
                'MiddleName'   => $request->get('MiddleName'),
                'Phone'   => $request->get('Phone'),
                'Email'   => $request->get('Email'),
                'Active'    => $active

            );
            try {

                /** @var Owner $owner */
                $owner = $this->_owners->create($options);
                if($owner->IsActive())
                    $this->_owners->deactivateAllButThis($owner->getId(),$owner->getFlatId());

            }catch(Exception $ex)
            {

                return \Redirect::route( 'owner.create' )->withInput()->with( $this->ShowMessage( 'Owner added Error:'.$ex->getMessage(), 'alert-danger' ) );
            }
            return \Redirect::route( 'owner.create' )->with( $this->ShowMessage( 'Owner added. Life is good.', 'alert-success' ) );
        }
    }

    public function edit(Request $request, $id)
    {
        $owner = $this->_owners->getById($id);
        $osmds = $this->_osmds->getAllActive();

        return view('cpanel.owners.edit')->with(array('owner'=>$owner,'osmds'=>$osmds));
    }

    public function update(Request $request,$id)
    {
        $validator = \Validator::make($request->all(),$this->rules);

        if($validator->fails())
        {
            return \Redirect::route('owner.edit',array("id"=>$id))->withInput()->withErrors($validator);
        }else
        {
            /** @var Owner $owner */
            $owner = $this->_owners->getById($id);
            $owner->setFlatId($request->get('Flat'));
            $owner->setFirstName($request->get("FirstName"));
            $owner->setLastName($request->get("LastName"));
            $owner->setMiddleName($request->get("MiddleName"));
            $owner->setPhone($request->get("Phone"));
            $owner->setEmail($request->get("Email"));

            try {

                $this->_owners->update($owner);

            }catch(Exception $ex)
            {

                return \Redirect::route( 'owner.create' )->withInput()->with( $this->ShowMessage( 'Owner updated Error:'.$ex->getMessage(), 'alert-danger' ) );
            }
            return \Redirect::route( 'owner.create' )->with( $this->ShowMessage( 'Owner updated. Life is good.', 'alert-success' ) );
        }
    }

    function destroy($id)
    {
        /** @var Owner $owner */
        $owner = $this->_owners->getById($id);
        $this->_owners->delete($owner);

        return \Redirect::route('sub.owner.all',array('id'=>$owner->Flat->getId()));
    }

    public function openClose($active,$id)
    {
        /** @var Owner $owner */
        $owner = $this->_owners->getById($id);

        switch ($active) {
            case 'open':
                $owner->setActive(1);
                $this->_owners->deactivateAllButThis($owner->getId(),$owner->getFlatId());
                break;
            case 'close':

                break;

        }
        $this->_owners->update($owner);
        return \Redirect::route('sub.owner.all',array('id'=>$owner->Flat->getId()));
    }

    //----------------------------------------------------------------------

    function owner_all(Request $request,$id,$obj_id=null)
    {
        $flat = $this->_flats->getById($id);
        $owners = $this->_owners->getByFlatId($id);
        return view('cpanel.owners.list')->with(array('flat'=>$flat,'owners'=>$owners));
    }

    function owner_add(Request $request,$id,$obj_id=null)
    {
        $flat = $this->_flats->getById($id);
        return view("cpanel.owners.add")->with(array('flat'=>$flat));
    }
    function owner_add_post(Request $request,$id,$obj_id=null)
    {
        $validator = \Validator::make($request->all(),$this->rules);

        if($validator->fails())
        {
            return \Redirect::route('sub.owner.add',array('id'=>$id))->withInput()->withErrors($validator);
        }else
        {
            $active    = $request->get( 'Active' );
            $active    = ( isset( $active ) && $active == '1' ) ? true : false;


            $options   = array(
                'FlatId'=>$request->get('Flat'),
                'FirstName'=>$request->get("FirstName"),
                'LastName'=>$request->get('LastName'),
                'MiddleName'   => $request->get('MiddleName'),
                'Phone'   => $request->get('Phone'),
                'Email'   => $request->get('Email'),
                'Active'    => $active

            );
            try {

                /** @var Owner $owner */
                $owner = $this->_owners->create($options);
                if($owner->IsActive())
                    $this->_owners->deactivateAllButThis($owner->getId(),$owner->getFlatId());

            }catch(Exception $ex)
            {

                return \Redirect::route( 'sub.owner.add' ,array('id'=>$id))->withInput()->with( $this->ShowMessage( 'Owner added Error:'.$ex->getMessage(), 'alert-danger' ) );
            }
            return \Redirect::route( 'sub.owner.add' ,array('id'=>$id))->with( $this->ShowMessage( 'Owner added. Life is good.', 'alert-success' ) );
        }
    }

    function owner_edit(Request $request,$id,$obj_id=null)
    {
        $flat = $this->_flats->getById($id);
        $owner = $this->_owners->getById($obj_id);
        return view('cpanel.owners.edit')->with(array('owner'=>$owner,'flat'=>$flat));
    }

    function owner_edit_post(Request $request,$id,$obj_id=null)
    {

    }

}
