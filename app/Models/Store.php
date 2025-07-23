<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable=[
        'parent_id',
        'name',
        'image',
        'api_linked',
        'arrangement',
        'description',
        'color',
        'like_card_linked',
        'charge_info',
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
    public function scopeMain($query){
        return $query->where('parent_id', null);
    }
    public function categories()
    {
        return $this->hasMany(Store::class,'parent_id');
    }
    public function packages()
    {
        return $this->hasMany(Package::class,'store_id');
    }
    public function merchants()
    {
        return $this->belongsToMany(MerchantStore::class,'merchant_stores','store_id','merchant_id');
    }
    public function company()
    {
        return $this->belongsTo(Store::class,'parent_id')->withTrashed();;
    }
    public function getImageFullPathAttribute()
    {
        if ($this->image != null) {
            return asset('uploads/stores/' . $this->image);
        }
        return null;
    }
}
