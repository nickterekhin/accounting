<?php

namespace App\Models;

/**
 * App\Models\PaymentStatus
 *
 * @property integer $id
 * @property string $Name
 * @property boolean $Active
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereActive($value)
 * @property-read \App\Models\Payment[] $Payments
 */
class PaymentStatus extends \Eloquent
{
    protected $table='PaymentStatus';
    public $timestamps = false;
    protected $fillable = ['Name','Active'];

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
    public function getName(): string
    {
        return $this->Name;
    }

    /**
     * @param string $Name
     */
    public function setName(string $Name): void
    {
        $this->Name = $Name;
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


    public function Payments()
    {
        return $this->hasMany('App\Models\Payment',"PaymentStatusId");
    }


}
