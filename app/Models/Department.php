<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $guarded=['id'];

    protected $casts=[
        'name'=>'json',
        'stores_id'=>'array',
    ];
    public function scopeOrder($query){
        return $query->orderBy('id', 'desc');
    }
    public function stores()
    {
        return $this->hasMany(Store::class, 'id', 'stores_id');
    }
    public function getImageFullPathAttribute()
    {
        if ($this->image != null) {
            return asset('uploads/departments/' . $this->image);
        }
        return null;
    }
}
