<?php


namespace App\Models\ModelProvider\impl;


use App\Models\FlatView;
use App\Models\ModelProvider\IFlatsViews;
use Eloquent;
use Illuminate\Database\Eloquent\Collection;

class FlatsViews extends BaseModel implements IFlatsViews
{

    function __construct($uid)
    {
        $this->_user_id = $uid;
    }

    /**
     * @param array $options
     * @return Eloquent
     */
    function create(array $options)
    {
        // TODO: Implement create() method.
    }

    /**
     * @return Collection
     */
    function getAll()
    {
        return FlatView::where('uid','=',$this->_user_id)->get();
    }

    /**
     * @param $id
     * @return Eloquent
     */
    function getById($id)
    {
       return FlatView::where('uid','=',$this->_user_id)->find($id);
    }

    /**
     * @return Collection
     */
    public function getAllActive()
    {
        // TODO: Implement getAllActive() method.
    }
}