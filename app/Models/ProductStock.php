<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductStock extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'product_name',
        'current_stock',
        'total_stock',
        'code',
        'sell_price'
    ];

    protected $table = 'product_stocks';
    public $incrementing = true;
}
