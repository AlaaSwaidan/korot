<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseProduct extends Model
{
    use HasFactory;
    protected $fillable=[
        'purchase_order_id',
        'product_id',
        'quantity',
        'price',
         'tax',
        'total',
        'choose_tax',
        'discount_amount',
    ];
    public function package()
    {
        return $this->belongsTo(Package::class,'product_id')->withTrashed();;
    }
}
