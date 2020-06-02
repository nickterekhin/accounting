<?php

namespace App\Providers;

use App\Dobby\Dobby;
use App\Models\ModelProvider\impl\Banks;
use App\Models\ModelProvider\impl\Buildings;
use App\Models\ModelProvider\impl\Discounts;
use App\Models\ModelProvider\impl\Flats;
use App\Models\ModelProvider\impl\FlatsViews;
use App\Models\ModelProvider\impl\Osmds;
use App\Models\ModelProvider\impl\Owners;
use App\Models\ModelProvider\impl\Payments;
use App\Models\ModelProvider\impl\Receipts;
use App\Models\ModelProvider\impl\Tarifes;
use App\Models\Tarif;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    private $_dobby;

    /**
     * Bootstrap any application services.
     *
     * @param \Request $request
     * @return void
     */

    public function boot()
    {
        view()->share('hideManageButtons', false);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //$this->app->bind('App\Models\ModelProvider\IOsmd','App\Models\ModelProvider\Impl\Osmds');

        $this->app->call([$this,'registerModels']);

        $this->app->bind('App\Models\ModelProvider\IAddresses','App\Models\ModelProvider\Impl\Addresses');
        $this->app->bind('App\Models\ModelProvider\IAddressTypes','App\Models\ModelProvider\Impl\AddressTypes');


        //$this->app->bind('App\Models\ModelProvider\ITarifes','App\Models\ModelProvider\Impl\Tarifes');
        //$this->app->bind('App\Models\ModelProvider\IReceipts','App\Models\ModelProvider\Impl\Receipts');
    }

    public function registerModels()
    {

        $user_id = \Dobby::getUserId();

        $this->app->bind('App\Models\ModelProvider\IOsmd',function() use ($user_id){
            return new Osmds($user_id);
        });
        //$this->app->bind('App\Models\ModelProvider\IBuildings','App\Models\ModelProvider\Impl\Buildings');
        $this->app->bind('App\Models\ModelProvider\IBuildings',function() use ($user_id){
            return new Buildings($user_id);
        });
        //$this->app->bind('App\Models\ModelProvider\IBanks','App\Models\ModelProvider\Impl\Banks');
        $this->app->bind('App\Models\ModelProvider\IBanks',function() use ($user_id){
            return new Banks($user_id);
        });
        //$this->app->bind('App\Models\ModelProvider\IFlats','App\Models\ModelProvider\Impl\Flats');
        $this->app->bind('App\Models\ModelProvider\IFlats',function() use ($user_id){
            return new Flats($user_id);
        });

        //$this->app->bind('App\Models\ModelProvider\IOwners','App\Models\ModelProvider\Impl\Owners');
        $this->app->bind('App\Models\ModelProvider\IOwners',function() use ($user_id){
            return new Owners($user_id);
        });

        //$this->app->bind('App\Models\ModelProvider\IReceipts','App\Models\ModelProvider\Impl\Receipts');
        $this->app->bind('App\Models\ModelProvider\IReceipts',function() use ($user_id){
            return new Receipts($user_id);
        });

        $this->app->bind('App\Models\ModelProvider\ITarifes',function()use($user_id){
            return new Tarifes($user_id);
        });
        $this->app->bind('App\Models\ModelProvider\IPayments',function()use($user_id){
            return new Payments($user_id);
        });

        $this->app->bind('App\Models\ModelProvider\IDiscounts',function() use ($user_id){
            return new Discounts($user_id);
        });

        $this->app->bind('App\Models\ModelProvider\IFlatsViews',function() use ($user_id){
            return new FlatsViews($user_id);
        });
    }



}
