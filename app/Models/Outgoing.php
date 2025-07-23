<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outgoing extends Model
{
    use HasFactory;
    protected $fillable=[
        'invoice_id',
        'discount',
        'date',
        'company_name',
        'tax_number',
        'tax',
        'amount',
        'total',
        'quantity',
        'notes',
        'payment_method',
        'bank_id',
        'confirm',
    ];
    public function scopeOrder($query){
        return $query->orderBy('id', 'desc');
    }
    public function bank()
    {
        return $this->belongsTo(Bank::class,'bank_id');
    }
}
