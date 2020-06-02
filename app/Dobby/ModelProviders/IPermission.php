<?php

namespace App\Dobby\ModelProviders;


use App\Models\Permission;
use Illuminate\Database\Eloquent\Collection;

interface IPermission
{
    /**
     * @param array $permOption
     * @return Permission
     */
    function create($permOption);

    /**
     * @param Permission $perm
     * @return bool
     */
    function delete(Permission $perm);

    /**
     * @return Collection
     */
    function getAll();

    /**
     * @param int $id
     * @return Permission
     */
    function getById($id);

    /**
     * @param string $name
     * @return Permission
     */
    function getByName($name);
}