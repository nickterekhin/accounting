<?php

namespace App\Models;

/**
 * App\Models\Tarif
 *
 * @property integer $id
 * @property integer $uid
 * @property string $Title
 * @property double $Amount
 * @property boolean $AmountType
 * @property boolean $Active
 * @property integer $Created
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereUid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereAmountType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereActive($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereCreated($value)
 * @property-read \App\Models\Receipt[] $Receipts
 *
 */

class Tarif extends \Eloquent
{
    protected $table='Tarifs';
    public $timestamps = false;
    protected $fillable = ['uid','Title','Amount','AmountType','Active','Created'];

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
     * @return float
     */
    public function getAmount(): float
    {
        return $this->Amount;
    }

    /**
     * @param float $Amount
     */
    public function setAmount(float $Amount): void
    {
        $this->Amount = $Amount;
    }

    /**
     * @return bool
     */
    public function isAmountType(): bool
    {
        return $this->AmountType;
    }

    /**
     * @param bool $AmountType
     */
    public function setAmountType(bool $AmountType): void
    {
        $this->AmountType = $AmountType;
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


    public function getType()
    {
        if($this->isAmountType())
            return '%';
        else
            return 'грн';
    }

    /**
     * @return int
     */
    public function getCreated(): int
    {
        return $this->Created;
    }

    /**
     * @param int $Created
     */
    public function setCreated(int $Created): void
    {
        $this->Created = $Created;
    }

    public function Receipts()
    {
        return $this->hasMany('App\Models\Receipt','TarifId');
    }

}
