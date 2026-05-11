<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RestockItem extends Model
{
    protected $fillable = [
        'restock_id',
        'product_id',
        'qty',
    ];

    public function restock()
    {
        return $this->belongsTo(Restock::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}