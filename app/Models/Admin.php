<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Modules\Transfers\Entities\Transfer;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use HasRoles;
    use SoftDeletes;

    protected $fillable = [
        'name', 'email', 'password', 'phone','type','balance','status',
        'collection_total',
        'transfer_total',
        'indebtedness',
        'repayment_total',
        'active_session_id',
    ];


    protected $hidden = [
        'password', 'remember_token',
    ];


    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }


//    public function hasPermission($permission) {
//
//        $adminPermissions = $this->permissions;
//
//        foreach ($adminPermissions as $adminPermission) {
//
//            if( $permission == $adminPermission->name ) {
//                return true;
//            }
//        }
//        return false;
//    }

    public function scopeType($query){
        return $query->where('type', 'super_admin');
    }
    public function scopeOrder($query){
        return $query->orderBy('id', 'desc');
    }
    public function providerable()
    {
        return $this->morphMany(Transfer::class, 'providerable');
    }
    public function userable()
    {

        return $this->morphMany(Transfer::class, 'userable');
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new AdminResetPasswordNotification($token));
    }
}
