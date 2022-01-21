<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 * @property mixed $method
 */
class Payment extends Model
{
    use HasFactory;

    const ORDER_ID = 'order_id',
        METHOD = 'method',
        GATEWAY = 'gateway',
        REF_NUM = 'ref_num',
        AMOUNT = 'amount',
        STATUS = 'status';

    protected $fillable = [
        self::ORDER_ID, self::METHOD,
        self::GATEWAY, self::REF_NUM,
        self::AMOUNT, self::STATUS
    ];

    protected $attributes = [
        self::STATUS => 0
    ];

    public function isOnline(): bool
    {
        return $this->method === 'online';
    }

}
