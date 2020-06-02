<?php

namespace App\Models;

/**
 * App\Models\Bank
 *
 * @property integer $id
 * @property string $TypeName
 * @property bool $Active
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereTypeName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereActive($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Address[] $Addresses
 *
 */
class AddressType extends \Eloquent
{

    protected $table='AddressType';
    public $timestamps = false;
    protected $fillable = ['TypeName','Active'];

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
    public function getTypeName(): string
    {
        return $this->TypeName;
    }

    /**
     * @param string $Type
     */
    public function setTypeName(string $Type): void
    {
        $this->TypeName = $Type;
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
    public function Addresses()
    {
        return $this->hasMany('App\Models\Address','TypeId');
    }
}
