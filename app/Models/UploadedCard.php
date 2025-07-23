<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UploadedCard extends Model
{
    use HasFactory;
    protected $fillable=[
        'package_id',
        'card_number',
        'serial_number',
        'end_date',
        'reason',
        'error',
    ];
    public function scopeOrder($query){
        return $query->orderBy('id', 'desc');
    }
    public function package()
    {
        return $this->belongsTo(Package::class,'package_id')->withTrashed();;
    }
}
