<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $dates = [
        'created_at',
        'updated_at',
        // your other new column
    ];
    protected $fillable = [
        'userable_id',
        'userable_type',
        'type',
        'title',
        'message',
        'notifiable_id',
        'notifiable_type',
        'seen'
    ];

}
