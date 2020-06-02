<?php

namespace App\Models;

/**
 * App\Models\Payment
 *
 * @property integer $id
 * @property integer $uid
 * @property integer $ReceiptId
 * @property float $Amount
 * @property integer $Created
 * @property integer $ParentId
 * @property integer $PaymentStatusId
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereUid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereReceiptId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereCreated($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereParentId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd wherePaymentStatus($value)
 * @property-read \App\Models\Receipt $Receipt
 * @property-read \App\Models\PaymentStatus $PaymentStatus
 * @property integer $level;
 */

class Payment extends \Eloquent
{
    protected $table='Payments';
    public $timestamps = false;
    protected $fillable = ['uid','ReceiptId','Amount','Created','ParentId','PaymentStatusId'];

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
    public function getReceiptId(): int
    {
        return $this->ReceiptId;
    }

    /**
     * @param int $ReceiptId
     */
    public function setReceiptId(int $ReceiptId): void
    {
        $this->ReceiptId = $ReceiptId;
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

    public function Receipt()
    {
        return $this->belongsTo('App\Models\Receipt','ReceiptId');
    }

    /**
     * @return int
     */
    public function getParentId(): int
    {
        return $this->ParentId;
    }

    /**
     * @param int $ParentId
     */
    public function setParentId(int $ParentId): void
    {
        $this->ParentId = $ParentId;
    }

    /**
     * @return int
     */
    public function getPaymentStatusId(): int
    {
        return $this->PaymentStatusId;
    }

    /**
     * @param int $PaymentStatusId
     */
    public function setPaymentStatusId(int $PaymentStatusId): void
    {
        $this->PaymentStatusId = $PaymentStatusId;
    }

    /**
     * @return int
     */
    public function getLevel(): int
    {
        return $this->level;
    }

    /**
     * @param int $level
     */
    public function setLevel(int $level): void
    {
        $this->level = $level;
    }


    public function PaymentStatus()
    {
        return $this->belongsTo('App\Models\PaymentStatus','PaymentStatusId');
    }


}
