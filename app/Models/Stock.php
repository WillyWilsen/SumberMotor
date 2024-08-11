<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'item_id',
        'quantity'
    ];

    protected $table = 'stocks';
    public $incrementing = true;

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'id');
    }
}
