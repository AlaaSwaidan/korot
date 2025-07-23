<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;
    protected $fillable=[
        'package_id',
        'card_number',
        'serial_number',
        'end_date',
        'sold',
        'imported',
        'cart_type',
    ];
    public function scopeOrder($query){
        return $query->orderBy('id', 'desc');
    }
    public function scopeSold($query){
        return $query->where('sold', 1);
    }
    public function scopeNotSold($query){
        return $query->where('sold', 0);
    }

    public function package()
    {
        return $this->belongsTo(Package::class,'package_id')->withTrashed();;
    }
    public function getFullNameAttribute()
    {
        return  $this->package->category->company->name['ar'].' - '.$this->package->category->name['ar'] .' - '.$this->package->name['ar'];

    }
    public function orders()
    {
        return $this->hasMany(Order::class, 'card_number', 'card_number');
    }

}
