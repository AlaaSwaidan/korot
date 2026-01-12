<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Modules\Merchant\Entities\MerchantPrice;
use Modules\Transfers\Entities\Transfer;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Merchant extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable=[
    'added_by',
    'added_by_type',
    'distributor_id',
    'name',
    'phone',
    'password',
    'email',
    'image',
    'tax_number',
    'active',
    'approve',
    'type',
    'commercial_number',
    'location',
    'machine_number',
    'balance',
    'collection_total',
    'transfer_total',
    'indebtedness',
    'repayment_total',
    'brand_name',
    'language',
    'commercial_image',
    'confirmed',
    'confirm_code',
    'profits',
    'sales',
    'geidea_user_name',
    'geidea_serial_number',
    'geidea_pass',
    'geidea_percentage',
    'street',
    'distinct',
    'zipcode',
    'building_number',
    'extra_number',
    'city_id',
    'region_id',
    'mada_pay',
    'last_login_at',
    ];
    protected $hidden = [
        'password',
    ];

    public function getJWTIdentifier()

    {

        return $this->getKey();

    }

    public function getJWTCustomClaims()

    {

        return [];

    }
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
    public function scopeOrder($query){
        return $query->orderBy('id', 'desc')->where('confirmed',1);
    }
    public function admin()
    {
        return $this->belongsTo(Admin::class,'added_by');
    }
    public function prices()
    {
        return $this->hasMany(MerchantPrice::class,'merchant_id');
    }
    public function distributor()
    {
        return $this->belongsTo(Distributor::class,'distributor_id')->withTrashed();
    }
    public function city()
    {
        return $this->belongsTo(City::class,'city_id');
    }
    public function orders()
    {
        return $this->hasMany(Order::class,'merchant_id');
    }
    public function getImageFullPathAttribute()
    {
        if ($this->image != null) {
            return asset('uploads/merchants/' . $this->image);
        }
        return null;
    }
    public function providerable()
    {
        return $this->morphMany(Transfer::class, 'providerable');
    }
    public function userable()
    {

        return $this->morphMany(Transfer::class, 'userable');
    }
    public function devices()
    {

        return $this->morphMany(UserDevice::class, 'userable');
    }
    public function tokens()
    {

        return $this->morphMany(UserToken::class, 'userable');
    }

}
