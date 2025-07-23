<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'supplier_id',
        'type',
        'tax_number',
        'address',
        'email',
        'phone',
        'mobile',
        'commercial_number',
        'country_id',
        'city_id',
        'purchases_total',
        'invoices_total',
    ];
    public function scopeOrder($query){
        return $query->orderBy('id', 'desc');
    }
    public function country()
    {
        return $this->belongsTo(Country::class,'country_id');
    }
    public function city()
    {
        return $this->belongsTo(City::class,'city_id');
    }
    public function invoices()
    {
        return $this->hasMany(PurchaseOrder::class,'supplier_id');
    }
}
