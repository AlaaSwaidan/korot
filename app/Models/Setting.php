<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $fillable=[
        'updated_by',
        'name',
        'email',
        'phone',
        'about',
        'terms',
        'bank_name',
        'bank_address',
        'account_number',
        'bank_code',
        'transaction_count',
        'transaction_days',
        'transaction_lowest_count',
        'transaction_lowest_day',
        'geidea_percentage',

        'current_version',
        'version_status',
        'version_date',
        'version_apk_link',

        'distributor_current_version',
        'distributor_version_status',
        'distributor_version_date',
        'distributor_version_apk_link',
        'shutdown_app',
    ];
    protected $casts=[
        'about'=>'json',
        'terms'=>'json',
        'name'=>'json',
        'bank_name'=>'json',
        'bank_address'=>'json',
    ];

}
