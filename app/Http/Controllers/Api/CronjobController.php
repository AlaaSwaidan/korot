<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Models\DuplicatedCard;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\Transfers\Entities\Transfer;

class CronjobController extends Controller
{
    //
    public function cancel_order()
    {
        // get all "not_paid" parents older than 10 minutes
        $ordersToCancel = Order::where('paid_order', 'not_paid')
            ->whereNull('parent_id')
//            ->whereDate('created_at', '>', '2025-02-06')
            ->where('created_at', '<=', now()->subMinutes(10))
            ->get();

        foreach ($ordersToCancel as $order) {

            // Cancel child orders
            foreach ($order->children as $childOrder) {
                // if you need to check cards:
                $card = Card::where([
                    ['package_id', $childOrder->package_id],
                    ['card_number', $childOrder->card_number],
                    ['serial_number', $childOrder->serial_number]
                ])->first();

                if ($card) {
                    // check if any other paid order is using it
                    $cardUsed = Order::where([
                        ['package_id', $childOrder->package_id],
                        ['card_number', $childOrder->card_number],
                        ['serial_number', $childOrder->serial_number],
                        ['paid_order', 'paid']
                    ])
                        ->whereNotNull('parent_id')
                        ->exists();

                    $card->update(['sold' => $cardUsed ? 1 : 0]);
                }

                $childOrder->update(['paid_order' => 'cancel']);
            }

            // finally, cancel the parent order
            $order->update(['paid_order' => 'cancel']);
        }

        // to cancel charge wallet not confirmed pay
        $chargeWallet = Transfer::where('paid_order', 'not_paid')
            ->where('type','recharge')
//            ->whereDate('created_at', '>', '2025-02-06')
            ->where('created_at', '<=', now()->subMinutes(10))
            ->get();
        foreach ($chargeWallet as $wallet) {
            $wallet->update(['paid_order' => 'cancel']);
        }


//        $this->info('Cancellation completed for unpaid orders older than 10 minutes.');
    }

//    public function cancel_order(){
//
//        $all_orders = Order::where('paid_order',"not_paid")->where('parent_id',null)
//            ->whereDate('created_at', '>', '2025-02-06')->get();
//
//          foreach ($all_orders as  $order){
//              if (Carbon::parse($order->created_at)->addMinutes(10) <= Carbon::now() ){
//                  $orders = Order::where('parent_id',$order->id)->get();
//                  foreach ($orders as $item){
//                      $cards = Card::where('package_id',$item->package_id)
//                          ->where('card_number',$item->card_number)
//                          ->where('serial_number',$item->serial_number)
//                          ->first();
//                      if ($cards){
//                          $get_order = Order::where('package_id',$item->package_id)
//                              ->where('card_number',$item->card_number)
//                              ->where('serial_number',$item->serial_number)
//                              ->where('paid_order',"paid")
//                              ->where('parent_id','!=',null)
//                              ->first();
//                          $cards->update([
//                              'sold'=>$get_order ? 1 : 0
//                          ]);
//                      }
////                      if ($cards){
////                          $cards->update([
////                              'sold'=>0
////                          ]);
////                      }
//
//                      $item->update([
//                          'paid_order'=>"cancel"
//                      ]);
//                  }
//                $order->update([
//                    'paid_order'=>"cancel"
//                ]);
//              }
//
//            }
//    }
    public function duplicate_cards()
    {
//        $duplicatedCards = DB::table('cards')
////            ->where('imported',1)
//            ->where('sold',0)
////            ->whereDate('created_at',Carbon::now())
//            ->select('card_number', DB::raw('COUNT(*) as count'))
//            ->groupBy('card_number')
//            ->having('count', '>', 1)
//            ->get();
        $duplicatedCards = DB::table('cards as c1')
            //            ->where('imported',1)
            ->where('sold',0)
//            ->whereDate('created_at',Carbon::now())
            ->select('c1.card_number','c1.id', 'c1.serial_number','c1.end_date','c1.package_id')
            ->join(DB::raw('(SELECT card_number, MIN(id) as min_id FROM cards GROUP BY card_number HAVING COUNT(*) > 1) as c2'), 'c1.card_number', '=', 'c2.card_number')
            ->where('c1.id', '!=', DB::raw('c2.min_id')) // Exclude the first occurrence
            ->get();
        $arr = [];
        foreach ($duplicatedCards as $card){
//            dd($card->card_number);
            $arr[] = [
                'card_number'=>$card->card_number,
                'serial_number'=>$card->serial_number,
                'package_id'=>$card->package_id,
                'end_date'=>$card->end_date,
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
            ];
        }
        DB::table('duplicated_cards')->insert($arr);
        $cards = $duplicatedCards->pluck('id')->toArray();
        Card::whereIn('id',$cards)->delete();
    }
}
