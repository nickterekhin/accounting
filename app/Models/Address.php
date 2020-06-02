<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Bank
 *
 * @property integer $id
 * @property int $TypeId
 * @property string $ObjectId
 * @property string $City
 * @property int $Country
 * @property string $Street1
 * @property string $Street2
 * @property string $Zip
 * @property bool $Active
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereTypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereObjectId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereCountry($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereCity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereStreet1($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereStreet2($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereZip($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereActive($value)
 * @property-read \App\Models\AddressType $Types
 */

class Address extends \Eloquent
{
    protected $table='Address';
    public $timestamps = false;
    protected $fillable = ['TypeId','ObjectId','City','Country','City','Street1','Street2','Zip','Active'];

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
    public function getTypeId(): string
    {
        return $this->TypeId;
    }

    /**
     * @param int $Type
     */
    public function setTypeId(int $Type): void
    {
        $this->TypeId= $Type;
    }

    /**
     * @return string
     */
    public function getObjectId(): string
    {
        return $this->ObjectId;
    }

    /**
     * @param string $ObjectId
     */
    public function setObjectId(string $ObjectId): void
    {
        $this->ObjectId = $ObjectId;
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
     * @return int
     */
    public function getCountry(): int
    {
        return $this->Country;
    }

    /**
     * @param int $Country
     */
    public function setCountry(int $Country): void
    {
        $this->Country = $Country;
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

    public function Types()
    {
        return $this->belongsTo('App\Models\AddressType','TypeId');
    }

}
