<?php

namespace App\Dobby\ModelProviders;


use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface IUser
{
    /**
     * @param array $userOptions
     * @return User
     */
    public function create($userOptions);

    /**
     * @param int $Id
     * @return User
     */
    public function getById($Id);

    /**
     * @param string $name
     * @return User
     */
    public function getByName($name);

    /**
     * @return Collection
     */
    public function getAll();

    /**
     * @param $password
     * @param $loginName
     * @param $flag
     * @return User
     */
    public function getUserByCredential($password,$loginName,$flag);

    /**
     * @param User $user
     * @return bool
     */
    public function delete(User $user);

    /**
     * @param int $id
     * @return bool
     */
    public function deleteById($id);

    /**
     * @param string $permsString
     * @return array();
     */
    public function getPermissions($permsString);

    /**
     * @param User $user
     * @return bool
     */
    public function update(User $user);

    /**
     * @param int $id
     * @return bool
     */
    public function getUserState($id);

}