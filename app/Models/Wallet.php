<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Transfers\Entities\Transfer;

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
    public function transfer() {
        return $this->belongsTo(Transfer::class);
    }

    public function merchant() {
        return $this->belongsTo(Merchant::class);
    }
}
