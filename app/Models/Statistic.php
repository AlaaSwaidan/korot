<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    use HasFactory;
    protected $fillable=[
        'total_sales',
        'api_sales',
        'not_api_sales',

        'total_card_sold',
        'api_card_sold',
        'not_api_card_sold',

        'total_cost',
        'api_card_cost',
        'not_api_card_cost',

        'total_profits',
        'api_card_profits',
        'not_api_card_profits',

        'total_mine_profits',
        'api_mine_card_profits',
        'not_mine_api_card_profits',

        'card_numbers',

        'distributors_balance',
        'merchants_balance',
        'admins_balance',

        'digital_balance',
        'geidea_commission',
        'geidea_wallet',
    ];
}
