<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Receipt
 *
 * @property integer $id
 * @property integer $uid
 * @property integer $Number
 * @property integer $FlatId
 * @property integer $Month
 * @property integer $Year
 * @property integer $Created
 * @property integer $TarifId
 * @property double $Amount
 * @property double $Total
 * @property integer $StatusId
 * @property boolean $Active
 * @property boolean $Archived
 * @property array $OutstandingList
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereUid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereNUmber($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereFlatId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereMonth($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereYear($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereCreated($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereTarifId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereTotal($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereStatusId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereActive($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereArchived($value)
 * @property-read \App\Models\Flat $Flat
 * @property-read \App\Models\ReceiptStatus $Status
 * @property-read \App\Models\Tarif $Tarif
 * @property-read \App\Models\Payment[] $Payments
 * @property float $Overpaid
 * @property float $Outstanding
 * @property float $Discount
 */

class Receipt extends \Eloquent
{
    protected $table='Receipt';
    public $timestamps = false;
    protected $fillable = ['uid','Number','FlatId','Month','Year','Created','TarifId','Amount','Total','StatusId','Active','Archived'];

    private $months = array(
        1=>'Январь',
        2=>'Февраль',
        3=>'Март',
        4=>'Апрель',
        5=>'Май',
        6=>'Июнь',
        7=>'Июль',
        8=>'Август',
        9=>'Сунтябрь',
        10=>'Октябрь',
        11=>'Ноябрь',
        12=>'Декабрь'
    );


    function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    /**
     *
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
    public function getNumber(): int
    {
        return $this->Number;
    }

    /**
     * @param int $Number
     */
    public function setNumber(int $Number): void
    {
        $this->Number = $Number;
    }

    /**
     * @return int
     */
    public function getFlatId(): int
    {
        return $this->FlatId;
    }

    /**
     * @param int $FlatId
     */
    public function setFlatId(int $FlatId): void
    {
        $this->FlatId = $FlatId;
    }

    /**
     * @return int
     */
    public function getMonth(): int
    {
        return $this->Month;
    }

    /**
     * @param int $Month
     */
    public function setMonth(int $Month): void
    {
        $this->Month = $Month;
    }

    /**
     * @return int
     */
    public function getYear(): int
    {
        return $this->Year;
    }

    /**
     * @param int $Year
     */
    public function setYear(int $Year): void
    {
        $this->Year = $Year;
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
     * @return int
     */
    public function getTarifId(): int
    {
        return $this->TarifId;
    }

    /**
     * @param int $TarifId
     */
    public function setTarifId(int $TarifId): void
    {
        $this->TarifId = $TarifId;
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
     * @return float
     */
    public function getTotal(): float
    {
       return $this->Total;
    }

    /**
     * @param float $Total
     */
    public function setTotal(float $Total): void
    {
        $this->Total = $Total;
    }

    /**
     * @return int
     */
    public function getStatusId(): int
    {
        return $this->StatusId;
    }

    /**
     * @param int $StatusId
     */
    public function setStatusId(int $StatusId): void
    {
        $this->StatusId = $StatusId;
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

    /**
     * @return bool
     */
    public function isArchived(): bool
    {
        return $this->Archived;
    }

    /**
     * @param bool $Archived
     */
    public function setArchived(bool $Archived): void
    {
        $this->Archived = $Archived;
    }

    function Flat()
    {
        return $this->belongsto('App\Models\Flat','FlatId');
    }

    function Status()
    {
        return $this->belongsTo('App\Models\ReceiptStatus','StatusId');
    }

    function Tarif()
    {
        return $this->belongsTo('App\Models\Tarif','TarifId');
    }

    function Payments()
    {
        return $this->hasMany('\App\Models\Payment','ReceiptId');
    }

    function getDate()
    {
        return $this->months[$this->getMonth()].' '.$this->getYear();
    }

    /**
     * @return float
     */
    public function getOverpaid(): float
    {
        return $this->Overpaid??0;
    }

    /**
     * @param float $Overpaid
     */
    public function setOverpaid(float $Overpaid): void
    {
        $this->Overpaid = $Overpaid;
    }

    /**
     * @return float
     */
    public function getOutstanding(): float
    {
        return $this->Outstanding??0;
    }

    /**
     * @param float $Outstanding
     */
    public function setOutstanding(float $Outstanding): void
    {
        $this->Outstanding = $Outstanding;
    }

    /**
     * @return float
     */
    public function getDiscount(): float
    {
        return $this->Discount;
    }

    public function getFullTotal()
    {
        return $this->Total+$this->Outstanding-$this->Overpaid;
    }

    public function setOutstandingList(array $res)
    {
        $this->OutstandingList = $res;
    }
    public function getOutstandingList() : array
    {
        return $this->OutstandingList??array();
    }


}
