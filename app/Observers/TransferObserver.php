<?php

namespace App\Observers;

use App\Models\Admin;
use App\Models\Merchant;
use App\Models\Statistic;
use Modules\Transfers\Entities\Transfer;

class TransferObserver
{

    public function created(Transfer $id)
    {
        $statistics = Statistic::find(1);
        $transfer = Transfer::find($id->id);
        //collection transfer indebtedness repayment profits payment recharge sales
        if ($transfer->type == "sales"){
            if ($transfer->api_linked == 0){

                $not_api_sales = $transfer->amount + $statistics->not_api_sales;
                $not_api_card_sold = 1 + $statistics->not_api_card_sold;
                $not_api_card_cost = $transfer->order->cost + $statistics->not_api_card_cost;
                $not_api_card_profits = $statistics->not_api_card_profits + ($transfer->profits);
                /*ارباح الشركة*/
                $not_mine_api_card_profits = $statistics->not_mine_api_card_profits + ($transfer->order->merchant_price - $transfer->order->cost);

            }else{
                $api_sales = $transfer->amount + $statistics->api_sales;
                $api_card_sold = 1 + $statistics->api_card_sold;
                $api_card_cost = $transfer->order->cost + $statistics->api_card_cost;
                $api_card_profits = $statistics->api_card_profits + ($transfer->profits);
              /*ارباح الشركة*/
                $api_mine_card_profits = $statistics->api_mine_card_profits + ($transfer->order->merchant_price - $transfer->order->cost);
            }

            $statistics->update([
                'total_sales'=>$statistics->total_sales + $transfer->amount,
                'not_api_sales'=> isset($not_api_sales) ? $not_api_sales :$statistics->not_api_sales,
                'api_sales'=> isset($api_sales) ? $api_sales :$statistics->api_sales,
                'not_api_card_sold'=> isset($not_api_card_sold) ? $not_api_card_sold :$statistics->not_api_card_sold,
                'api_card_sold'=> isset($api_card_sold) ? $api_card_sold :$statistics->api_card_sold,
                'total_card_sold' => 1 + $statistics->total_card_sold,
                'card_numbers'=>$statistics->card_numbers - 1,
                'total_cost'=>$statistics->total_cost + $transfer->order->cost,
                'api_card_cost'=>isset($api_card_cost) ? $api_card_cost :$statistics->api_card_cost,
                'not_api_card_cost'=>isset($not_api_card_cost) ? $not_api_card_cost :$statistics->not_api_card_cost,

                'total_profits'=>$statistics->total_profits + ($transfer->profits),
                'api_card_profits'=>isset($api_card_profits) ? $api_card_profits :$statistics->api_card_profits,
                'not_api_card_profits'=>isset($not_api_card_profits) ? $not_api_card_profits :$statistics->not_api_card_profits,


                'total_mine_profits'=>$statistics->total_mine_profits + ($transfer->order->merchant_price - $transfer->order->cost),
                'api_mine_card_profits'=>isset($api_mine_card_profits) ? $api_mine_card_profits :$statistics->api_mine_card_profits,
                'not_mine_api_card_profits'=>isset($not_mine_api_card_profits) ? $not_mine_api_card_profits :$statistics->not_mine_api_card_profits,
            ]);
            if ( $transfer->userable_type == "App\Models\Merchant"){
                if ($transfer->order->payment_method == "wallet"){
                    $statistics->update([
                        'merchants_balance'=>$statistics->merchants_balance - $transfer->amount,
                    ]);
                }


            }elseif($transfer->userable_type == "App\Models\Distributor"){
                 $statistics->update([
                        'distributors_balance'=>$statistics->distributors_balance - $transfer->amount,
                    ]);

            }elseif($transfer->userable_type == "App\Models\Admin"){
                    $statistics->update([
                        'admins_balance'=>$statistics->admins_balance - $transfer->amount,
                    ]);
            }
        }
        elseif ($transfer->type == "restore"){
            if ($transfer->api_linked == 0){

                $not_api_sales =   $statistics->not_api_sales - $transfer->amount;
                $not_api_card_sold =  $statistics->not_api_card_sold -1 ;
                $not_api_card_cost =  $statistics->not_api_card_cost - $transfer->order->cost;
                $not_api_card_profits = $statistics->not_api_card_profits - ($transfer->profits);
                /*ارباح الشركة*/
                $not_mine_api_card_profits = $statistics->not_mine_api_card_profits - ($transfer->order->merchant_price - $transfer->order->cost);

            }else{
                $api_sales =  $statistics->api_sales - $transfer->amount;
                $api_card_sold = $statistics->api_card_sold - $transfer->amount;
                $api_card_cost = $statistics->api_card_cost - $transfer->order->cost;
                $api_card_profits = $statistics->api_card_profits - ($transfer->profits);
              /*ارباح الشركة*/
                $api_mine_card_profits = $statistics->api_mine_card_profits - ($transfer->order->merchant_price - $transfer->order->cost);
            }

            $statistics->update([
                'total_sales'=>$statistics->total_sales - $transfer->amount,
                'not_api_sales'=> isset($not_api_sales) ? $not_api_sales :$statistics->not_api_sales,
                'api_sales'=> isset($api_sales) ? $api_sales :$statistics->api_sales,
                'not_api_card_sold'=> isset($not_api_card_sold) ? $not_api_card_sold :$statistics->not_api_card_sold,
                'api_card_sold'=> isset($api_card_sold) ? $api_card_sold :$statistics->api_card_sold,
                'total_card_sold' => $statistics->total_card_sold -1,
                'card_numbers'=>$statistics->card_numbers + 1,
                'total_cost'=>$statistics->total_cost - $transfer->order->cost,
                'api_card_cost'=>isset($api_card_cost) ? $api_card_cost :$statistics->api_card_cost,
                'not_api_card_cost'=>isset($not_api_card_cost) ? $not_api_card_cost :$statistics->not_api_card_cost,

                'total_profits'=>$statistics->total_profits - ($transfer->profits),
                'api_card_profits'=>isset($api_card_profits) ? $api_card_profits :$statistics->api_card_profits,
                'not_api_card_profits'=>isset($not_api_card_profits) ? $not_api_card_profits :$statistics->not_api_card_profits,


                'total_mine_profits'=>$statistics->total_mine_profits - ($transfer->order->merchant_price - $transfer->order->cost),
                'api_mine_card_profits'=>isset($api_mine_card_profits) ? $api_mine_card_profits :$statistics->api_mine_card_profits,
                'not_mine_api_card_profits'=>isset($not_mine_api_card_profits) ? $not_mine_api_card_profits :$statistics->not_mine_api_card_profits,
            ]);
            if ( $transfer->userable_type == "App\Models\Merchant"){
                 $statistics->update([
                        'merchants_balance'=>$statistics->merchants_balance + $transfer->amount,
                    ]);

            }elseif($transfer->userable_type == "App\Models\Distributor"){
                 $statistics->update([
                        'distributors_balance'=>$statistics->distributors_balance + $transfer->amount,
                    ]);

            }elseif($transfer->userable_type == "App\Models\Admin"){
                    $statistics->update([
                        'admins_balance'=>$statistics->admins_balance + $transfer->amount,
                    ]);
            }
        }
        elseif (in_array($transfer->type,['transfer','repayment','profits','recharge','sales'])){
            if($transfer->confirm == 1){
                if ( $transfer->userable_type == "App\Models\Merchant"){
                    if ($transfer->type == "sales"){
                        $statistics->update([
                            'merchants_balance'=>$statistics->merchants_balance + $transfer->profits,
                        ]);
                    }else{
                        if ($transfer->pay_type == "online"){
                            $merchant = Merchant::find($transfer->userable_id);
                            $percentage = $merchant->geidea_percentage ? $merchant->geidea_percentage : settings()->geidea_percentage;
                            $get_commission = $transfer->amount * $percentage ;
                            $result = ($transfer->amount) - $get_commission;
                            $statistics->update([
                                'merchants_balance'=>$statistics->merchants_balance + $result,
                            ]);
                        }else{
                            $statistics->update([
                                'merchants_balance'=>$statistics->merchants_balance + $transfer->amount,
                            ]);
                        }

                    }
                }
                elseif($transfer->userable_type == "App\Models\Distributor"){
                    if ($transfer->type == "sales"){
                        $statistics->update([
                            'distributors_balance'=>$statistics->distributors_balance + $transfer->profits,
                        ]);
                    }else{
                        $statistics->update([
                            'distributors_balance'=>$statistics->distributors_balance + $transfer->amount,
                        ]);
                    }
                }
                elseif($transfer->userable_type == "App\Models\Admin"){
                    if ($transfer->type == "sales"){
                        $statistics->update([
                            'admins_balance'=>$statistics->admins_balance + $transfer->profits,
                        ]);
                    }else{
                        $statistics->update([
                            'admins_balance'=>$statistics->admins_balance + $transfer->amount,
                        ]);
                    }
                }
                /*  transfers  */
                if ($transfer->type == "transfer"){
                    if ($transfer->providerable_type == "App\Models\Merchant"){
                        $statistics->update([
                            'merchants_balance'=>$statistics->merchants_balance - $transfer->amount,
                        ]);
                    }elseif ($transfer->providerable_type == "App\Models\Distributor"){
                        $statistics->update([
                            'distributors_balance'=>$statistics->distributors_balance - $transfer->amount,
                        ]);
                    }elseif ($transfer->providerable_type == "App\Models\Admin"){
                        if (Admin::find($transfer->providerable_id)->type == "admin"){
                            $statistics->update([
                                'admins_balance'=>$statistics->admins_balance - $transfer->amount,
                            ]);
                        }

                    }
                }
            }


        }

    }

    /**
     * Handle the Transfer "updated" event.
     *
     * @param  \Modules\Transfers\Entities\Transfer  $transfer
     * @return void
     */
    public function updated(Transfer $transfer)
    {
        //
    }

    /**
     * Handle the Transfer "deleted" event.
     *
     * @param  \Modules\Transfers\Entities\Transfer  $transfer
     * @return void
     */
    public function deleted(Transfer $transfer)
    {
        //
    }

    /**
     * Handle the Transfer "restored" event.
     *
     * @param  \Modules\Transfers\Entities\Transfer  $transfer
     * @return void
     */
    public function restored(Transfer $transfer)
    {
        //
    }

    /**
     * Handle the Transfer "force deleted" event.
     *
     * @param  \Modules\Transfers\Entities\Transfer  $transfer
     * @return void
     */
    public function forceDeleted(Transfer $transfer)
    {
        //
    }
}
