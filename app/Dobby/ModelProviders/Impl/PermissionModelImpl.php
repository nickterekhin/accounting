<?php

namespace App\Dobby\ModelProviders\Impl;


use App\Dobby\ModelProviders\IPermission;
use App\Models\Permission;
use Illuminate\Database\Eloquent\Collection;

class PermissionModelImpl implements IPermission
{

    /**
     * @param array $permOption
     * @return Permission
     */
    function create($permOption)
    {
        // TODO: Implement create() method.
    }

    /**
     * @param Permission $perm
     * @return bool
     */
    function delete(Permission $perm)
    {
        // TODO: Implement delete() method.
    }

    /**
     * @return Collection
     */
    function getAll()
    {
        return Permission::all();
    }

    /**
     * @param int $id
     * @return Permission
     */
    function getById($id)
    {
        // TODO: Implement getById() method.
    }

    /**
     * @param string $name
     * @return Permission
     */
    function getByName($name)
    {
        // TODO: Implement getByName() method.
    }
}