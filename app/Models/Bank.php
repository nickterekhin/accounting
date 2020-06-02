<?php

namespace App\Models;

/**
 * App\Models\Bank
 *
 * @property integer $id
 * @property string $Title
 * @property string $Slug
 * @property string $mfo
 * @property string $City
 * @property string $Street1
 * @property string $Street2
 * @property string $Zip
 * @property bool $Active
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd wheremfo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereCity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereStreet1($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereStreet2($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereZip($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereActive($value)
 * @property-read \App\Models\Osmd[] $OsmdList
 *
 */
class Bank extends \Eloquent
{
    protected $table='Banks';
    public $timestamps = false;
    protected $fillable = ['Title','Slug','mfo','Active'];

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
     * @param string $slug
     */
    public function setSlug(string $slug): void
    {
        $this->Slug = $slug;
    }

    /**
     * @return string
     */
    public function getMfo(): string
    {
        return $this->mfo;
    }

    /**
     * @param string $mfo
     */
    public function setMfo(string $mfo): void
    {
        $this->mfo = $mfo;
    }

    /**
     * @return string
     */
    public function getCity(): ?string
    {
        return $this->City;
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
    public function setStreet1(string $Street1): void
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
    public function setZip(string $Zip): void
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
    public function OsmdList()
    {
        return $this->hasMany('App\Models\Osmd','BankId');
    }

}
