<?php

namespace App\Models;
/**
 * App\Models\Discount
 *
 * @property integer $id
 * @property integer $uid
 * @property integer $OwnerId
 * @property string $Title
 * @property integer $Created
 * @property float $Amount
 * @property bool $Active
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereUid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereOwnerId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereCreated($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereActive($value)
 * @property-read \App\Models\Owner $Owner
 *
 */

class Discount extends \Eloquent
{
    protected $table='Discounts';
    public $timestamps = false;
    protected $fillable = ['uid','Created','OwnerId','Title','Amount','Active'];

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
    public function getOwnerId(): int
    {
        return $this->OwnerId;
    }

    /**
     * @param int $OwnerId
     */
    public function setOwnerId(int $OwnerId): void
    {
        $this->OwnerId = $OwnerId;
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


    public function Owner()
    {
        return $this->belongsTo("App\Models\Owner","OwnerId");
    }

    public function getAmountWithSymbol()
    {
        if($this->Amount<1)
            return '%'.$this->Amount;

        return $this->Amount.' грн';
    }






}
