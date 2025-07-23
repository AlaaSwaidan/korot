<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserToken extends Model
{
    use HasFactory;
    protected $fillable=[
        'userable_id',
        'userable_type',
        'device_id' ,
        'access_token',
    ];
    public function user()
    {
        return $this->morphTo(__FUNCTION__, 'userable_type', 'userable_id');
    }
    public function distributor()
    {
        return $this->morphTo(__FUNCTION__, 'userable_type', 'userable_id');
    }
    public function merchant()
    {
        return $this->morphTo(__FUNCTION__, 'userable_type', 'userable_id');
    }
}
