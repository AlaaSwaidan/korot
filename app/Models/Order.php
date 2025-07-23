<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Modules\Transfers\Entities\Transfer;

class Order extends Model
{
    use HasFactory;
    protected $fillable=[
        'parent_id',
        'merchant_id',
        'name',
        'package_id',
        'card_number',//
        'serial_number',//
        'cost',//
        'card_price',//
        'merchant_price',//
        'end_date',//
        'status',
        'count',//
        'image',
        'color',
        'api_linked',//
        'print_status',//
        'company_name',
        'description',
        'payment_method',
        'transaction_id',
        'paid_order',
        'total',
        'cart_type',
    ];
    protected $casts=[
        'name'=>'json',
        'company_name'=>'json',
        'description'=>'json',
    ];
    public function getPaidOrderAttribute($value)
    {
        if ($this->attributes['paid_order'] == "not_paid"){
            if (Carbon::parse($this->created_at)->addMinutes(10) <= Carbon::now() ){
                $orders = Order::where('parent_id',$this->id)->get();
                foreach ($orders as $item){
                    $cards = Card::where('package_id',$item->package_id)
                        ->where('card_number',$item->card_number)
                        ->where('serial_number',$item->serial_number)
                        ->first();
                    $item->update([
                        'paid_order'=>"cancel"
                    ]);
                    if ($cards){
                        $get_order = Order::where('package_id',$item->package_id)
                            ->where('card_number',$item->card_number)
                            ->where('serial_number',$item->serial_number)
                            ->where('paid_order',"paid")
                            ->where('parent_id','!=',null)
                            ->first();
                        $cards->update([
                            'sold'=>$get_order ? 1 : 0
                        ]);
                    }


                }
                $this->update([
                    'paid_order'=>"cancel"
                ]);
            }
        }

        return $this->attributes['paid_order'];
    }
    public function merchant()
    {
        return $this->belongsTo(Merchant::class,'merchant_id')->withTrashed();;
    }
    public function card()
    {
        return $this->hasOne(Card::class, 'card_number', 'card_number');
    }
    public function package()
    {
        return $this->belongsTo(Package::class,'package_id')->withTrashed();;
    }
    public function transfer()
    {
        return $this->belongsTo(Transfer::class,'order_id')->withTrashed();;
    }
    public function parent()
    {
        return $this->belongsTo(Order::class,'parent_id');
    }
    public function children()
    {
        return $this->hasMany(Order::class, 'parent_id');
    }
}
