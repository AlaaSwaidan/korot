<?php

namespace Modules\Transfers\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BankTransfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'transfer_id',
        'amount',
        'bank_name',
        'bank_address',
        'bank_city',
        'bank_country',
    ];

    protected static function newFactory()
    {
        return \Modules\Transfers\Database\factories\BankTransferFactory::new();
    }
}
