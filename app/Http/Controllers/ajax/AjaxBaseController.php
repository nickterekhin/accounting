<?php

namespace App\Http\Controllers\ajax;

use App\Helpers\RespondJScript;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AjaxBaseController extends Controller
{
    /**
     * @var Request
     */
    protected $request;
    /**
     * @var RespondJScript
     */
    protected $respond;

    function __construct()
    {
        $this->respond = new RespondJScript();
    }

    /**
     * @param Request $request
     */
    function driver(Request $request)
    {
        $id = $request->get('id');
        if(isset($id) && $id==1)
        {
            $this->request=$request;

            $function = !empty($request->get('cmd'))?$request->get('cmd'):"";
            /** @var RespondJScript $r*/
            $r = $this->$function();
            echo $r->getOutput();
            die();
        }
    }
}