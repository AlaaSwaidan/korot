<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;
    protected $fillable=[
        'transfer_id',
        'merchant_id',
        'balance',
        'previous_balance',
        'current_balance',
        'date',
    ];
}
