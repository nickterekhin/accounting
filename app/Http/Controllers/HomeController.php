<?php


namespace App\Http\Controllers;


use Debugbar;
use Illuminate\Http\Request;

class HomeController extends BaseController
{
        function __construct()
        {
            parent::__construct();
        }

        function index()
        {
            if(\Dobby::isLoggedIn())
            {
                Debugbar::addMessage('redirect to admin');
                return redirect('cpanel');
            }

            return view('login');
        }
    public function login(Request $request)
    {

        $credential = array(
            'password'=>$request->get('password'),
            'login'=>$request->get('email')

        );

        \Debugbar::info($credential);

        if(\Dobby::login($credential))
        {
            return \Redirect::to('cpanel');
        }

        return \Redirect::route("home")->withErrors(array('message' => 'Login failed. UserName or Password incorrect.'));
    }
}