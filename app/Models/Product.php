<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $id
 * @property mixed $stock
 * @method static find($all)
 */
class Product extends Model
{
    use HasFactory;

    public function hasStock($quantity): bool
    {
        return $this->stock >= $quantity;
    }
}
