<?php

namespace App\Http\Controllers\CPanel;

use App\Models\ModelProvider\ITarifes;
use App\Models\Tarif;
use Exception;
use Illuminate\Http\Request;

class TarifController extends CPanelBaseController
{

    private $_tarifes;
    private  $rules = array(
        'Title'=>'required',
        'Amount'=>'required',
        'Type'=>'required',
    );
    /**
     * TarifController constructor.
     * @param ITarifes $tarifes
     */
    public function __construct(ITarifes $tarifes)
    {
        $this->_tarifes = $tarifes;
    }

    function index()
    {
        $tarif = $this->_tarifes->getAll();
        return view('cpanel.tarif.list')->with(array('tarifes'=>$tarif));
    }

    function create()
    {
        return view('cpanel.tarif.add');
    }

    function store(Request $request)
    {
        $validator = \Validator::make($request->all(),$this->rules);

        if($validator->fails())
        {
            return \Redirect::route('tarif.create')->withInput()->withErrors($validator);
        }else
        {

            $options   = array(
                'Title'=>$request->get("Title"),
                'Amount'=>$request->get("Amount"),
                'Type'   => $request->get('Type'),
                'Created'=>time(),
                'Active'    => true,

            );
            try{

                /** @var Tarif $o */
                $o = $this->_tarifes->create($options);
                if($o->isActive())
                {
                    $this->_tarifes->setInactiveExclude($o->getId());
                }

            }catch (Exception $ex)
            {
                 return \Redirect::route( 'tarif.create' )->withInput()->with( $this->ShowMessage( 'Tarif added Error:'.$ex->getMessage(), 'alert-danger' ) );
            }
            return \Redirect::route( 'tarif.create' )->with( $this->ShowMessage( 'Tarif added. Life is good.', 'alert-success' ) );
        }
    }
    function edit($id)
    {
        $tarif = $this->_tarifes->getById($id);
        return view('cpanel.tarif.edit')->with(array("tarif"=>$tarif));
    }

}
