<?php

namespace App\Dobby\ModelProviders;


use App\Models\UserGroup;
use Illuminate\Database\Eloquent\Collection;

interface IUserGroup
{
    /**
     * @param array $groupOptions
     * @return UserGroup
     */
    function create($groupOptions);

    /**
     * @param int $id
     * @return UserGroup
     */
    function getById($id);

    /**
     * @param string $groupName
     * @return UserGroup
     */
    function getByNme($groupName);

    /**
     * @param $groupId
     * @return array()
     */
    function getPermissionsByGroupId($groupId);

    /**
     * @return Collection
     */
    function getAll();

    /**
     * @return Collection
     */
    function getAllActive();

    /**
     * @param UserGroup $ug
     * @return bool
     */
    function delete(UserGroup $ug);

    /**
     * @param UserGroup $ug
     * @return bool
     */
    function update(UserGroup $ug);

}