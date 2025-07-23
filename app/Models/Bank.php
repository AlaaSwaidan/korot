<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'account_number',
        'type',
        'balance',
    ];
    protected $casts=[
        'name'=>'json'
    ];
    public function scopeOrder($query){
        return $query->orderBy('id', 'desc');
    }
}
