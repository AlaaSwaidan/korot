<?php

namespace Modules\Merchant\Entities;

use App\Models\Merchant;
use App\Models\Package;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MerchantPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'added_by',
        'merchant_id',
        'package_id',
        'old_price',
        'price',
        'type',
    ];

    public function scopeOrder($query){
        return $query->orderBy('id', 'desc');
    }
    public function merchant()
    {
        return $this->belongsTo(Merchant::class,'merchant_id');
    }
    public function package()
    {
        return $this->belongsTo(Package::class,'package_id')->withTrashed();
    }
    protected static function newFactory()
    {
        return \Modules\Merchant\Database\factories\MerchantPriceFactory::new();
    }
}
