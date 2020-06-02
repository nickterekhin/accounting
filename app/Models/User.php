<?php

namespace App\Models;

/**
 * App\Models\User
 *
 * @property-read \static::$userGroupsModel $group
 * @property integer $uid
 * @property integer $ugroup
 * @property string $FirstName
 * @property string $LastName
 * @property string $UserName
 * @property string $email
 * @property string $Password
 * @property boolean $Active
 * @property integer $RegDate
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereUid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereUgroup($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereFirstName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereLastName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereUserName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereActive($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereRegDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereUpdatedAt($value)
 * @property integer $RegData
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereRegData($value)
 */
class User extends \Eloquent
{
    protected $table = 'users';
    protected $primaryKey = 'uid';
    protected $userGroup;
    protected static $userGroupsModel = 'App\Models\UserGroup';
    protected $fillable = ['ugroup','FirstName','LastName','UserName','email','Password','Active','RegDate'];

    public function getId()
    {
        return $this->getKey();
    }

    /**
     * @return int
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * @param int $uid
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
    }

    /**
     * @return int
     */
    public function getUgroup()
    {
        return $this->ugroup;
    }

    /**
     * @param int $ugroup
     */
    public function setUgroup($ugroup)
    {
        $this->ugroup = $ugroup;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->FirstName;
    }

    /**
     * @param string $FirstName
     */
    public function setFirstName($FirstName)
    {
        $this->FirstName = $FirstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->LastName;
    }

    /**
     * @param string $LastName
     */
    public function setLastName($LastName)
    {
        $this->LastName = $LastName;
    }

    /**
     * @return string
     */
    public function getUserName()
    {
        return $this->UserName;
    }

    /**
     * @param string $UserName
     */
    public function setUserName($UserName)
    {
        $this->UserName = $UserName;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->Password;
    }

    /**
     * @param string $Password
     */
    public function setPassword($Password)
    {
        $this->Password = $Password;
    }

    /**
     * @return boolean
     */
    public function isActive()
    {
        return (bool) $this->Active;
    }

    /**
     * @param boolean $Active
     */
    public function setActive($Active)
    {
        $this->Active = $Active;
    }

    /**
     * @return int
     */
    public function getRegDate()
    {
        return date("d-m-Y",$this->RegDate);
    }

    /**
     * @param int $RegDate
     */
    public function setRegDate($RegDate)
    {
        $this->RegDate = $RegDate;
    }

    public function getGroupName()
    {
        return $this->GroupName;
    }

    public function getPermissions()
    {
        return $this->Permissions;
    }

    public function getFullName()
    {
        return $this->FirstName.' '.$this->LastName;
    }


    /*------------Groups------------*/

    /**
     * @return UserGroup
     */
    public function getGroup(){
        if(!$this->userGroup) {
            $this->userGroup = $this->group();
        }
        return $this->userGroup;
    }

    public function group()
    {
        return $this->belongsTo(static::$userGroupsModel,'ugroup');
    }

    public function getLogin()
    {
        return $this->{'email'};
    }

}