<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Seeder;

class DuplicateOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
//        $orders = Order::where('parent_id',null)->where('id','<=',26856)->get();
//        foreach ($orders as $order){
//            $order->update([
//                'total'=>$order->card_price
//            ]);
//            $newOrder = $order->replicate();
//            $newOrder->parent_id = $order->id;
//            $newOrder->save();
//        }
    }
}
