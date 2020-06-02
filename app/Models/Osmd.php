<?php

namespace App\Models;
use DateTime;

/**
 * App\Models\Osmd
 *
 * @property integer $id
 * @property integer $uid
 * @property string $Title
 * @property string $Slug
 * @property string $Okpo
 * @property string $BankId
 * @property integer $AddedAt
 * @property string $City
 * @property string $Street1
 * @property string $Street2
 * @property string $Zip
 * @property bool $Active
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereUid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereOkpo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereBankId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereAddedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereCity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereStreet1($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereStreet2($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereZip($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereActive($value)
 * @property-read \App\Models\Bank $Bank
 * @property-read \App\Models\Building[] $Buildings
 * @property string $Account
 *
 */
class Osmd extends \Eloquent
{
    protected $table='osmds';
    public $timestamps = false;
    protected $fillable = ['uid','Title','Slug','Okpo','BankId','AddedAt','City','Street1','Street2','Zip','Active','Account'];

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
    public function getOkpo(): string
    {
        return $this->Okpo;
    }

    /**
     * @param string $okpo
     */
    public function setOkpo(string $okpo): void
    {
        $this->Okpo = $okpo;
    }

    /**
     * @return string
     */
    public function getBankId(): string
    {
        return $this->BankId;
    }

    /**
     * @param string $bankId
     */
    public function setBankId(string $bankId): void
    {
        $this->BankId = $bankId;
    }

    /**
     * @return int
     */
    public function getAddedAt(): int
    {
        return $this->AddedAt;
    }

    /**
     * @param int $AddedAt
     */
    public function setAddedAt(int $AddedAt): void
    {
        $this->AddedAt = $AddedAt;
    }



    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->City;
    }

    /**
     * @param string $City
     */
    public function setCity(string $City): void
    {
        $this->City = $City;
    }

    /**
     * @return string
     */
    public function getStreet1(): string
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
    public function getZip(): string
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

    public function Bank()
    {
        return $this->belongsTo('App\Models\Bank','BankId');
    }
    public function Buildings()
    {
        return $this->hasMany('App\Models\Building','OsmdId');
    }

    /**
     * @return string
     */
    public function getAccount(): string
    {
        return $this->Account;
    }

    /**
     * @param string $Account
     */
    public function setAccount(string $Account): void
    {
        $this->Account = $Account;
    }


}
