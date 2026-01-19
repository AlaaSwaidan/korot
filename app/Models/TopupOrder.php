<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopupOrder extends Model
{
    use HasFactory;
    protected $fillable=[
        'merchant_id',
        'phone',
        'country_code',
        'sku_code',
        'price',
        'sell_price',
        'receive_amount',
        'merchant_percentage',
        'merchant_profit',
        'admin_profit'
    ];

}
