<?php

namespace App\Dobby\ModelProviders\Impl;


use App\Dobby\ModelProviders\IUserGroup;
use App\Models\UserGroup;
use Illuminate\Database\Eloquent\Collection;

class UserGroupModelImpl implements IUserGroup
{

    /**
     * @param array $groupOptions
     * @return UserGroup
     */
    function create($groupOptions)
    {
        $ug = new UserGroup($groupOptions);

        if($ug->save())
            return $ug;

        return null;
    }

    /**
     * @param int $id
     * @return UserGroup
     */
    function getById($id)
    {
        return UserGroup::find($id);
    }

    /**
     * @param string $groupName
     * @return UserGroup
     */
    function getByNme($groupName)
    {
        // TODO: Implement getByNme() method.
    }

    /**
     * @param $groupId
     * @return array()
     */
    function getPermissionsByGroupId($groupId)
    {
            return explode(",",UserGroup::select("permission")->where("ugroup","=",$groupId)->get());
    }

    /**
     * @return Collection
     */
    function getAll()
    {
        return UserGroup::all();
    }

    /**
     * @return Collection
     */
    function getAllActive()
    {
        // TODO: Implement getAllActive() method.
    }

    /**
     * @param UserGroup $ug
     * @return bool
     */
    function delete(UserGroup $ug)
    {
        // TODO: Implement delete() method.
    }

    /**
     * @param UserGroup $ug
     * @return bool
     */
    function update(UserGroup $ug)
    {
        return $ug->update();
    }

}