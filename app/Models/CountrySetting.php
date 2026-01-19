<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CountrySetting extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'country_code',
        'merchant_percentage',
    ];
}
