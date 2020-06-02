<?php

namespace App\Dobby;
use App\Dobby\ModelProviders\IUser;
use App\Models\User;
use Illuminate\Cookie\CookieJar;
use Illuminate\Http\Request;

class Dobby implements IDobby
{
    protected $user;
    protected $userProvider;
    protected $session;
    protected $request;
    protected $cookie;

    /**
     * @param IUser $userProvider
     * @param Request $request
     * @param CookieJar $cookie
     */
    public function __construct(IUser $userProvider, $request, CookieJar $cookie)
    {
        $this->userProvider = $userProvider;
        $this->request = $request;
        $this->cookie = $cookie;
    }

    public function getUserId()
    {
        if($this->user==null)
        {
            try{
                $this->user = $this->request->session()->get('user');

            }catch(\Exception $ex)
            {

                $user_id = $this->request->cookie('user_id');

                if($user_id!=null) {

                    return \Crypt::decryptString($user_id);
                }
            }
        }
        return -1;
    }
    /**
     * @return bool
     */
    public function initUser()
    {

        $uid = $this->request->cookie('uid'); $passwd = $this->request->cookie('pwd');

        if($uid!=null && $passwd!=null)
        {
            $this->user = $this->request->session()->get('user');

            if(!$this->user)
            {
                $user = $this->userProvider->getUserByCredential($passwd,$uid,true);

                if($user!=null)
                {
                    $this->request->session()->put('user',$user);
                    $this->request->session()->put('isLogged', 1);
                    $this->request->session()->put('permissions', $this->userProvider->getPermissions($user->getGroup->Permissions));
                    $this->user = $user;
                    return true;
                }
            }else
            {
                return true;
            }
        }
        else
        {
            $this->request->session()->flush();
        }
        $this->request->session()->put('isLogged',0);
        return false;

    }
    public function login(array $credential, $remember = false,$flag=null)
    {

        $this->user = $this->userProvider->getUserByCredential($credential['password'],$credential['login'],$flag);


        if($this->user!=null)
        {

            $this->cookie->queue($this->cookie->make('uid',$this->user->getLogin(),120,'/'));
            $this->cookie->queue($this->cookie->make('pwd',$this->user->getPassword(),120,'/'));
            $this->cookie->queue($this->cookie->make('user_id',$this->user->getId(),120,'/'));

            return true;
        }
        else
        {
            return false;
        }

    }
    public function logout()
    {
        $this->request->session()->forget('user');
        $this->request->session()->put('isLogged',0);
        $this->cookie->queue($this->cookie->forget('uid'));
        $this->cookie->queue($this->cookie->forget('pwd'));
        $this->cookie->queue($this->cookie->forget('user_id'));
    }

    public function reLogin($login,$password)
    {
        $this->logout();
        $this->login(array('password'=>$password,'login'=>$login),true,true);

    }

    /**
     *
     */
    public function isLoggedIn()
    {

        if($this->request->session()->get('isLogged')==1)
        {

            return true;
        }
        else
        {

            return false;
        }
    }

    /**
     * @param $permsString
     * @return bool
     */
    public function checkRights($permsString)
    {
        if(in_array('All',$this->request->session()->get("permissions")))
            return true;

        if(is_array($permsString))
        {
                foreach($permsString as $role)
                {
                    if(in_array($role,$this->request->session()->get("permissions")))
                        return true;
                }
        }
        else
        {
            if(in_array($permsString,$this->request->session()->get("permissions")))
                return true;
        }
        return false;
    }

    public function checkUserState()
    {

        if ($this->request->session()->get("user")!=null && $this->request->session()->get("user")->getId()!=1) {
            if (!$this->userProvider->getUserState($this->request->session()->get("user")->getId())) {
                $this->logout();
            }
        }
    }

    public function getRedirectRouteFromAction($route)
    {
        $action = $route->getAction();
        return isset($action['auth-redirect-to'])?$action['auth-redirect-to']:null;
    }

    public function getRolesFromAction($route)
    {
        $actions = $route->getAction();

        return isset($actions['roles']) ? $actions['roles'] : null;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

}