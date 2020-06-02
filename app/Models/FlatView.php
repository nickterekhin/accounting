<?php


namespace App\Models;

/**
 * App\Models\FlatView
 *
 * @property integer $id
 * @property integer $uid
 * @property integer $BuildingId
 * @property string $Number
 * @property string $Square
 * @property string $Section
 * @property string $Level
 * @property bool $Active
 * @property integer $OwnerId
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereUid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereBuildingId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereSquare($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereSection($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereLevel($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereActive($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Osmd whereOwnerId($value)
 * @property-read \App\Models\Building $Building
 * @property-read \App\Models\Owner $Owner
 * @property-read \App\Models\Receipt[] $Receipts
 * @property integer $People
 * @property string $PublicAccount
 * @property float $FinState
 *
 */
class FlatView extends \Eloquent
{
    protected $table='FlatsView';
    public $timestamps = false;
    protected $fillable = [];

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getUid(): int
    {
        return $this->uid;
    }

    /**
     * @return int
     */
    public function getBuildingId(): int
    {
        return $this->BuildingId;
    }

    /**
     * @return string
     */
    public function getNumber(): string
    {
        return $this->Number;
    }

    /**
     * @return string
     */
    public function getSquare(): string
    {
        return $this->Square;
    }

    /**
     * @return string
     */
    public function getSection(): string
    {
        return $this->Section;
    }

    /**
     * @return string
     */
    public function getLevel(): string
    {
        return $this->Level;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->Active;
    }

    /**
     * @return int
     */
    public function getOwnerId(): int
    {
        return $this->OwnerId;
    }


    public function Building()
    {
        return $this->belongsTo('App\Models\Building','BuildingId');
    }

    public function Owner()
    {
        return $this->hasOne('App\Models\Owner','FlatId');
    }

    public function Receipts()
    {
        return $this->hasMany('App\Models\Receipt','FlatId');
    }


    /**
     * @return int
     */
    public function getPeople(): int
    {
        return $this->People;
    }

    /**
     * @return string
     */
    public function getPublicAccount(): string
    {
        return $this->PublicAccount;
    }

    /**
     * @return float
     */
    public function getFinState(): float
    {
        return $this->FinState;
    }



}