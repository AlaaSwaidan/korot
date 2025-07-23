<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDevice extends Model
{
    use HasFactory;
    protected $fillable = [
        'device_identifier', 'firebase_token', 'is_open', 'userable_id',
        'userable_type',
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
    public function admin()
    {
        return $this->morphTo(__FUNCTION__, 'userable_type', 'userable_id');
    }
}
