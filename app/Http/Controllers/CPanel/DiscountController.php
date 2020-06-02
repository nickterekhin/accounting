<?php

namespace App\Http\Controllers\CPanel;

use App\Models\Discount;
use App\Models\ModelProvider\IDiscounts;
use App\Models\ModelProvider\IOwners;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DiscountController extends CPanelBaseController
{
    private $_owners;
    private $_discounts;
    private $rules=array(
        'Amount'=>'required',
        'Title'=>'required'
    );
    public function __construct(IOwners $owners,IDiscounts $discounts)
    {
        $this->_owners = $owners;
        $this->_discounts = $discounts;
    }

    function destroy($id)
    {
        /** @var Discount $discount */
        $discount = $this->_discounts->getById($id);
        $this->_discounts->delete($discount);

        return \Redirect::route('sub.discount.all',array('id'=>$discount->Owner->getId()));
    }

    public function openClose($active,$id)
    {
        /** @var Discount $discount */
        $discount = $this->_discounts->getById($id);

        switch ($active) {
            case 'open':
                $discount->setActive(1);
                break;
            case 'close':
                $discount->setActive(0);
                break;

        }
        $this->_discounts->update($discount);
        return \Redirect::route('sub.discount.all',array('id'=>$discount->Owner->getId()));
    }

    function discount_all(Request $request,$id,$obj_id=null)
    {
        $owner = $this->_owners->getById($id);
        $discounts_list = $this->_discounts->getByOwnerId($id);

        return view('cpanel.discounts.list')->with(array('discounts_list'=>$discounts_list,'owner'=>$owner));
    }

    function discount_add(Request $request,$id,$obj_id=null)
    {
        $owner = $this->_owners->getById($id);
        return view('cpanel.discounts.add')->with(array('owner'=>$owner));
    }
    function discount_add_post(Request $request,$id,$obj_id=null)
    {
        $validator = \Validator::make($request->all(),$this->rules);

        if($validator->fails())
        {
            return \Redirect::route('sub.discount.add',array('id'=>$id))->withInput()->withErrors($validator);
        }else
        {
            $active    = $request->get( 'Active' );
            $active    = ( isset( $active ) && $active == '1' ) ? true : false;

            $options   = array(
                'OwnerId'=>$request->get('Owner'),
                'Title'=>$request->get("Title"),
                'Created'=>time(),
                'Amount'   => $request->get('Amount'),
                'Active'    => $active

            );
            try {
                $this->_discounts->create($options);
            }catch(Exception $ex)
            {
                return \Redirect::route( 'sub.discount.add',array('id'=>$id) )->withInput()->with( $this->ShowMessage( 'Discount added Error:'.$ex->getMessage(), 'alert-danger' ) );
            }
            return \Redirect::route( 'sub.discount.add',array('id'=>$id) )->with( $this->ShowMessage( 'Discount added. Life is good.', 'alert-success' ) );
        }
    }


    function discount_edit(Request $request,$id,$obj_id=null)
    {

        $owner = $this->_owners->getById($id);

        $discount = $this->_discounts->getById($obj_id);


        return View('cpanel.discounts.edit')->with(array('discount'=>$discount,'owner'=>$owner));
    }
    function discount_edit_post(Request $request,$id,$obj_id=null)
    {
        $validator = \Validator::make($request->all(),$this->rules);

        if($validator->fails())
        {
            return \Redirect::route('sub.discount.edit',array('id'=>$request->get('Owner'),'obj_id'=>$obj_id))->withInput()->withErrors($validator);
        }else
        {
            $active    = $request->get( 'Active' );
            $active    = ( isset( $active ) && $active == '1' ) ? true : false;

            /** @var Discount $flat */
            $flat = $this->_discounts->getById($obj_id);
            $flat->setOwnerId($request->get('Owner'));
            $flat->setTitle($request->get('Title'));
            $flat->setAmount($request->get('Amount'));
            $flat->setActive($active);

            try {
                $this->_discounts->update($flat);
            }catch(Exception $ex)
            {
                return \Redirect::route( 'sub.discount.edit',array('id'=>$request->get('Owner'),'obj_id'=>$obj_id) )->withInput()->with( $this->ShowMessage( 'Discount updated Error:'.$ex->getMessage(), 'alert-danger' ) );
            }
            return \Redirect::route( 'sub.discount.edit' ,array('id'=>$request->get('Owner'),'obj_id'=>$obj_id))->with( $this->ShowMessage( 'Flat updated. Life is good.', 'alert-success' ) );
        }
    }
}
