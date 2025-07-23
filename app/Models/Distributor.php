<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Modules\Transfers\Entities\Transfer;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Distributor extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable ,SoftDeletes;
    protected $fillable=[
        'added_by',
        'added_by_type',
        'name',
        'phone',
        'password',
        'email',
        'image',
        'identity_id',
        'identity_image',
        'tax_number',
        'active',
        'balance',
        'collection_total',
        'transfer_total',
        'indebtedness',
        'repayment_total',
        'confirm_code',
        'confirmed',
        'offer_amount',
        'distributions',
        'profits',
        'transfers_total_check', // لاحسب مجموع التوزيعات حتى يتم تحويل الربح
        'current_token'
    ];
    protected $hidden = [
        'password',
    ];
    public function revokeAllTokens()
    {
        $this->tokens()->delete();
    }
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

    public function getImageFullPathAttribute()
    {
        if ($this->image != null) {
            return asset('uploads/distributors/' . $this->image);
        }
        return null;
    }
    public function getIdentityImageFullPathAttribute()
    {
        if ($this->image != null) {
            return asset('uploads/distributors/' . $this->identity_image);
        }
        return null;
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class,'added_by');
    }
    public function merchants()
    {
        return $this->hasMany(Merchant::class,'distributor_id');
    }
    public function providerable()
    {
        return $this->morphMany(Transfer::class, 'providerable');
    }
    public function userable()
    {

        return $this->morphMany(Transfer::class, 'userable');
    }
    public function tokens()
    {

        return $this->morphMany(UserToken::class, 'userable');
    }

}
