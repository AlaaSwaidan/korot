<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeadiaWallet extends Model
{
    use HasFactory;
    // شراء مباشر او شحن مباشر
    protected $fillable=[
        'user_id',
        'balance',
        'type',
        'transfer_id',
        'transaction_id'
    ];
    public function merchant()
    {
        return $this->belongsTo(Merchant::class,'user_id');
    }
}
