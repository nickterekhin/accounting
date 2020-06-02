<?php

namespace App\Dobby\ModelProviders\Impl;


use App\Dobby\ModelProviders\IUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;

class UsersModelImpl implements IUser
{
    private $user;
    private $userModel = 'App\Models\User';
    private $model;


    public function __construct()
    {
        $model = '\\'.ltrim($this->userModel, '\\');
        $this->model=new User;
    }


    /**
     * @param $password
     * @param $loginName
     * @param bool $flag
     * @return User
     */
    public function getUserByCredential($password, $loginName, $flag = null)
    {
        if($flag==null)
        {
            $flag=false;
        }
        \Debugbar::info($flag);
        // TODO: Implement getUserByCredential() method.
        if(!$flag) {
            $user = $this->model->newQuery()->with('getGroup')->where('email', '=', $loginName)->orWhere('UserName','=',$loginName)->where('Active', '=', 1)->first();

            if ($user != null) {
                if (\Hash::check($password, $user->getPassword())) {
                    \Debugbar::addMessage('hash matches - ' . Hash::make($password));
                    return $user;
                } else {
                    \Debugbar::addMessage('hash dose not match');
                    return null;
                }
            } else {
                return null;
            }
        }
        else
        {
            $user = $this->model->newQuery()->with('getGroup')->where('Password','=',$password)->where('email', '=', $loginName)->orWhere('UserName','=',$loginName)->where('Active', '=', 1)->first();
            if($user!=null)
            {
                return $user;
            }
            else
            {
                return null;
            }
        }
    }

    /**
     * @param $permsString
     * @return array
     */
    public function getPermissions($permsString)
    {
      return explode(",",$permsString);
    }


    /**
     * @param array $userOptions
     * @return User
     */
    public function create($userOptions)
    {
        $user = new User($userOptions);
        $user->save();
        return $user;
    }

    /**
     * @param int $Id
     * @return User
     */
    public function getById($Id)
    {
        return User::find($Id);
    }

    /**
     * @param string $name
     * @return User
     */
    public function getByName($name)
    {
        // TODO: Implement findByName() method.
    }

    /**
     * @return Collection
     */
    public function getAll()
    {
        return User::select(array("users.*","usergroups.*"))->leftJoin('usergroups','users.ugroup','=','usergroups.ugroup')->get();
    }

    /**
     * @param User $user
     * @return bool
     */
    public function delete(User $user)
    {
        if ($user->getId()==1) return false;
        return $user->delete();
    }

    /**
     * @param int $id
     * @return bool
     */
    public function deleteById($id)
    {
        // TODO: Implement deleteById() method.
    }

    /**
     * @param User $user
     * @return bool
     */
    public function  update(User $user)
    {
        if ($user->getId()==1 && session('user')->getId()!=1) return false;
        return $user->update();
    }

    /**
     * @param int $id
     * @return bool
     */
    public function getUserState($id)
    {

        $userState = User::select("Active")->where("uid", "=", $id)->get()->first();
        if($userState==null)
            return false;
        if(!$userState->Active)
            return false;

        return true;
    }
}