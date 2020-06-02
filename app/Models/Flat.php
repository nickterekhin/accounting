<?php

namespace App\Models;

/**
 * App\Models\Flat
 *
 * @property integer $id
 * @property integer $uid
 * @property integer $BuildingId
 * @property string $Number
 * @property string $Square
 * @property string $Section
 * @property string $Level
 * @property bool $Active
 * @property integer $OwnerId
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereUid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereBuildingId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereSquare($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereSection($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereLevel($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereActive($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereOwnerId($value)
 * @property-read \App\Models\Building $Building
 * @property-read \App\Models\Owner $Owner
 * @property-read \App\Models\Receipt[] $Receipts
 * @property string $Title
 * @property integer $People
 * @property string $PublicAccount
 *
 */
class Flat extends \Eloquent
{
    protected $table='Flats';
    public $timestamps = false;
    protected $fillable = ['uid','BuildingId','Number','Square','Section','Level','Active','OwnerId','People','PublicAccount'];

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
    public function getBuildingId(): int
    {
        return $this->BuildingId;
    }

    /**
     * @param int $BuildingId
     */
    public function setBuildingId(int $BuildingId): void
    {
        $this->BuildingId = $BuildingId;
    }

    /**
     * @return string
     */
    public function getNumber(): string
    {
        return $this->Number;
    }

    /**
     * @param string $Number
     */
    public function setNumber(string $Number): void
    {
        $this->Number = $Number;
    }

    /**
     * @return string
     */
    public function getSquare(): string
    {
        return $this->Square;
    }

    /**
     * @param string $Square
     */
    public function setSquare(string $Square): void
    {
        $this->Square = $Square;
    }

    /**
     * @return string
     */
    public function getSection(): string
    {
        return $this->Section;
    }

    /**
     * @param string $Section
     */
    public function setSection(string $Section): void
    {
        $this->Section = $Section;
    }

    /**
     * @return string
     */
    public function getLevel(): string
    {
        return $this->Level;
    }

    /**
     * @param string $Level
     */
    public function setLevel(string $Level): void
    {
        $this->Level = $Level;
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


    public function Building()
    {
        return $this->belongsTo('App\Models\Building','BuildingId');
    }


    public function Owner()
    {
        return $this->hasOne('App\Models\Owner','FlatId');
    }

    public function getTitle()
    {
        return $this->Title;
    }
    public function setTitle($title)
    {
        $this->Title = $title;
    }

    /**
     * @return int
     */
    public function getPeople(): int
    {
        return $this->People;
    }

    /**
     * @param int $People
     */
    public function setPeople(int $People): void
    {
        $this->People = $People;
    }

    /**
     * @return string
     */
    public function getPublicAccount(): string
    {
        return $this->PublicAccount;
    }

    /**
     * @param string $PublicAccount
     */
    public function setPublicAccount(string $PublicAccount): void
    {
        $this->PublicAccount = $PublicAccount;
    }


    public function Receipts()
    {
        return $this->hasMany('App\Models\Receipt','FlatId');
    }



}
