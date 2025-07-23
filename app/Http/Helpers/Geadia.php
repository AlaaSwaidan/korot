<?php

use App\Models\GeadiaWallet;
use  \App\Models\UserDevice;
use App\Models\Notification;

function add_geadia($user,$amount,$type,$transfer,$transaction_id)
{
    GeadiaWallet::create([
        'user_id'=>$user->id,
        'balance'=>$amount,
        'type'=>$type,
        'transfer_id'=>$transfer ? $transfer->id : null,
        'transaction_id'=>$transaction_id,
    ]);
    $statistics = \App\Models\Statistic::find(1);
    $statistics->update([
        'geidea_wallet'=>$statistics->geidea_wallet + $amount
    ]);
}
