<?php

namespace App\Dobby;


use Illuminate\Support\Facades\Facade;

class DobbyFacade extends Facade
{
    protected static function getFacadeAccessor(){return 'dobby';}
}