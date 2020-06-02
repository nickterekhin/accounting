<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use DispatchesJobs, ValidatesRequests;

    protected function ShowMessage($text, $cssClass)
    {
        $message = array();

        $message['form-message'] = $text;
        $message['form-message-type'] = $cssClass;

        return $message;
    }
}
