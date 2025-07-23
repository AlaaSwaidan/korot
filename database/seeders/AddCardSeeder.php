<?php

namespace Database\Seeders;

use App\Models\Card;
use App\Models\Statistic;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AddCardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        for ($i = 0 ; $i < 100  ; $i++){
            $card_number = "53462323".mt_rand(100000, 999999);
            $serial_number = "35122222".mt_rand(1000, 9999).mt_rand(1000, 9999);
            Card::create([
                'package_id'=>11,
                'card_number'=>$card_number,
                'serial_number'=>$serial_number,
                'end_date'=>Carbon::now()->addDays(5)->format('Y-m-d'),
            ]);
            $statistics = Statistic::find(1);
            $statistics->update([
                'card_numbers'=>$statistics->card_numbers + 1
            ]);
        }
        for ($i = 0 ; $i < 100  ; $i++){
            $card_number = "53462323".mt_rand(100000, 999999);
            $serial_number = "35122222".mt_rand(1000, 9999).mt_rand(1000, 9999);
            Card::create([
                'package_id'=>12,
                'card_number'=>$card_number,
                'serial_number'=>$serial_number,
                'end_date'=>Carbon::now()->addDays(5)->format('Y-m-d'),
            ]);
            $statistics = Statistic::find(1);
            $statistics->update([
                'card_numbers'=>$statistics->card_numbers + 1
            ]);
        }
        for ($i = 0 ; $i < 100  ; $i++){
            $card_number = "53462323".mt_rand(100000, 999999);
            $serial_number = "35122222".mt_rand(1000, 9999).mt_rand(1000, 9999);
            Card::create([
                'package_id'=>10,
                'card_number'=>$card_number,
                'serial_number'=>$serial_number,
                'end_date'=>Carbon::now()->addDays(5)->format('Y-m-d'),
            ]);
            $statistics = Statistic::find(1);
            $statistics->update([
                'card_numbers'=>$statistics->card_numbers + 1
            ]);
        }
    }
}
