<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * App\Models\Osmd
 *
 * @property integer $id
 * @property integer $uid
 * @property integer $OsmdId
 * @property string $Title
 * @property string $Slug
 * @property string $Levels
 * @property string $City
 * @property string $Street1
 * @property string $Street2
 * @property string $Zip
 * @property bool $Active
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereUid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereOsmdId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereLevels($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereCity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereStreet1($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereStreet2($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereZip($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereActive($value)
 * @property-read \App\Models\Osmd $Osmd
 * @property-read \App\Models\Flat[] $Flats
 *
 */
class Building extends \Eloquent
{
    protected $table='Buildings';
    public $timestamps = false;
    protected $fillable = ['uid','OsmdId','Title','Slug','Levels','Active'];

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
    public function getOsmdId(): int
    {
        return $this->OsmdId;
    }

    /**
     * @param int $OsmdId
     */
    public function setOsmdId(int $OsmdId): void
    {
        $this->OsmdId = $OsmdId;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->Title;
    }

    /**
     * @param string $Title
     */
    public function setTitle(string $Title): void
    {
        $this->Title = $Title;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->Slug;
    }

    /**
     * @param string $Slug
     */
    public function setSlug(string $Slug): void
    {
        $this->Slug = $Slug;
    }

    /**
     * @return string
     */
    public function getLevels(): string
    {
        return $this->Levels;
    }

    /**
     * @param string $Levels
     */
    public function setLevels(string $Levels): void
    {
        $this->Levels = $Levels;
    }

    /**
     * @return string
     */
    public function getCity(): ?string
    {
        return $this->City;
    }

    /**
     * @param string $City
     */
    public function setCity(?string $City): void
    {
        $this->City = $City;
    }

    /**
     * @return string
     */
    public function getStreet1(): ?string
    {
        return $this->Street1;
    }

    /**
     * @param string $Street1
     */
    public function setStreet1(?string $Street1): void
    {
        $this->Street1 = $Street1;
    }

    /**
     * @return string
     */
    public function getStreet2(): ?string
    {
        return $this->Street2;
    }

    /**
     * @param string $Street2
     */
    public function setStreet2(?string $Street2): void
    {
        $this->Street2 = $Street2;
    }

    /**
     * @return string
     */
    public function getZip(): ?string
    {
        return $this->Zip;
    }

    /**
     * @param string $Zip
     */
    public function setZip(?string $Zip): void
    {
        $this->Zip = $Zip;
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
    public function Osmd()
    {
        return $this->belongsTo('App\Models\Osmd','OsmdId');
    }


    public function Flats()
    {
        return $this->hasMany('App\Models\Flat','BuildingId');
    }

    /**
     * @return integer
     */
    public function getUid(): int
    {
        return $this->uid;
    }

    /**
     * @param integer $uid
     */
    public function setUid(int $uid): void
    {
        $this->uid = $uid;
    }


}
