<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $appends = ['total_cost','all_total_cost'];
    protected $fillable=[
        'store_id',
        'name',
        'description',
        'status',
        'card_price',
        'cost',
        'arrangement',
        'gencode',
        'gencode_like_card',
        'gencode_like_card_status',
        'gencode_status',
        'barcode',
        'zain_status',
        'price_zain',
        'product_id_zain',
        'twelve_status',
        'package_id_twelve',
    ];
    protected $casts=[
        'name'=>'json',
        'description'=>'json',
    ];

    public function scopeOrder($query){
        return $query->orderBy('id', 'desc');
    }
    public function scopeOrderByAdmin($query){
        return $query->orderBy('arrangement', 'asc');
    }
    public function prices()
    {
        return $this->hasMany(PackagePrice::class,'package_id');
    }
    public function category()
    {
        return $this->belongsTo(Store::class,'store_id')->withTrashed();;
    }
    public function cards()
    {
        return $this->hasMany(Card::class,'package_id');
    }
    public function getImageFullPathAttribute()
    {
        if ($this->image != null) {
            return asset('uploads/packages/' . $this->image);
        }
        return null;
    }
    public function totalCost(): Attribute
    {
        return Attribute::get(function () {
            return Card::where('package_id', $this->id)->where('sold',0)->count() * $this->cost;
        });


    }
    public function allTotalCost(): Attribute
    {
        return Attribute::get(function () {
            return Card::where('package_id', $this->id)->count() * $this->cost;
        });


    }
}
