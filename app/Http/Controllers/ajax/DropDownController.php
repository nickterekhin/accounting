<?php

namespace App\Http\Controllers\ajax;

use App\Models\ModelProvider\IBuildings;
use App\Models\ModelProvider\IFlats;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DropDownController extends AjaxBaseController
{

    private $_buildings;
    private $_flats;

    /**
     * DropDownController constructor.
     * @param IBuildings $buildings
     * @param IFlats $flats
     */
    public function __construct(IBuildings $buildings,IFlats $flats)
    {
        parent::__construct();
        $this->_buildings = $buildings;
        $this->_flats = $flats;
    }

    public function getBuildingsList()
    {
        $buildings = $this->_buildings->getByOsmdId($this->request->get('val'));
        $this->respond->script(json_encode($buildings));
        return $this->respond;
    }

    public function getFlatsList()
    {
        $flats = $this->_flats->getByBuildingId($this->request->get('val'));
        $this->respond->script(json_encode($flats));
        return $this->respond;
    }
}
