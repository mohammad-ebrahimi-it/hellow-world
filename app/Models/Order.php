<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @method static create(array $array)
 */
class Order extends Model
{
    use HasFactory;

    const USER_ID = 'user_id', CODE = 'code', AMOUNT = 'amount';

    protected $fillable = [self::USER_ID, self::CODE,self::AMOUNT ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity');
    }
}
