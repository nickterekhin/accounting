<?php

namespace App\Models;


/**
 * App\Models\Owner
 *
 * @property integer $id
 * @property integer $uid
 * @property integer $FlatId
 * @property string $FirstName
 * @property string $LastName
 * @property string $MiddleName
 * @property string $Phone
 * @property string $Email
 * @property bool $Active
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereUid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereFlatId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereFirstName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereLastName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereMiddleName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereActive($value)
 * @property-read \App\Models\Flat $Flat
 * @property-read \App\Models\Discount[] $Discounts
 *
 */
class Owner extends \Eloquent
{
    protected $table='Owners';
    public $timestamps = false;
    protected $fillable = ['uid','FlatId','FirstName','LastName','MiddleName','Phone','Email','Active'];

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getUid(): int
    {
        return $this->uid;
    }

    /**
     * @param int $uid
     */
    public function setUid(int $uid): void
    {
        $this->uid = $uid;
    }


    /**
     * @return int
     */
    public function getFlatId(): int
    {
        return $this->FlatId;
    }

    /**
     * @param int $FlatId
     */
    public function setFlatId(int $FlatId): void
    {
        $this->FlatId = $FlatId;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->FirstName;
    }

    /**
     * @param string $FirstName
     */
    public function setFirstName(string $FirstName): void
    {
        $this->FirstName = $FirstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->LastName;
    }

    /**
     * @param string $LastName
     */
    public function setLastName(string $LastName): void
    {
        $this->LastName = $LastName;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->Phone;
    }

    /**
     * @param string $Phone
     */
    public function setPhone(string $Phone): void
    {
        $this->Phone = $Phone;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->Email;
    }

    /**
     * @param string $Email
     */
    public function setEmail(string $Email): void
    {
        $this->Email = $Email;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->Active;
    }

    /**
     * @param bool $Active
     */
    public function setActive(bool $Active): void
    {
        $this->Active = $Active;
    }

    public function Flat()
    {
        return $this->belongsTo('App\Models\Flat','FlatId');
    }

    /**
     * @return string
     */
    public function getMiddleName(): string
    {
        return $this->MiddleName;
    }

    /**
     * @param string $MiddleName
     */
    public function setMiddleName(string $MiddleName): void
    {
        $this->MiddleName = $MiddleName;
    }


    public function getFullName()
    {
        return $this->LastName.' '.$this->FirstName.' '.$this->MiddleName;
    }

    public function Discounts()
    {
        return $this->hasMany('App\Models\Discount','OwnerId');
    }

}
