<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    use HasFactory;
    protected $fillable=[
        'invoice_id',
        'type',
        'bank_id',
        'account_number',
        'credit',
        'debit',
        'balance',
        'bank_id',
    ];
    public function scopeOrder($query){
        return $query->orderBy('id', 'desc');
    }
    public function bank()
    {
        return $this->belongsTo( Bank::class , 'bank_id');
    }
}
