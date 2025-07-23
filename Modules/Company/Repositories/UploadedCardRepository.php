<?php

namespace Modules\Company\Repositories;

use App\Models\Card;
use App\Models\Statistic;
use App\Models\Store;
use App\Models\UploadedCard;

class UploadedCardRepository
{


    public function store()
    {
        try {
            $card=UploadedCard::where('error',1)->delete();
            $cards = UploadedCard::get();
            foreach ($cards as $value){
                if (Card::where('card_number',$value->card_number)->OrWhere('serial_number',$value->serial_number)->count() == 0){
                    Card::create([
                        'card_number'     => $value->card_number,
                        'serial_number'    => $value->serial_number,
                        'end_date' => $value->end_date,
                        'package_id' => $value->package_id,
                        'imported' => 1,
                        'cart_type' => "imported",

                    ]);
                    $statistics = Statistic::find(1);
                    $statistics->update([
                        'card_numbers'=>$statistics->card_numbers + 1
                    ]);
                }
            }
           UploadedCard::where('error',0)->delete();
            return true;
        } catch (\Exception $exception) {
            return redirect()->route('admin.uploaded-card-index.index')->with('warning', 'Error , contact system');
        }
    }
    public function cancel()
    {
        try {
             UploadedCard::where('error',1)->delete();
             UploadedCard::where('error',0)->delete();
            return true;
        } catch (\Exception $exception) {
            return redirect()->route('admin.uploaded-card-index.index')->with('warning', 'Error , contact system');
        }
    }

    public function update($request, $card)

    {
        try {
            $request['error']=0;
            $updated = $card->update($request->all());

            return $updated;
        } catch (\Exception $exception) {
            return redirect()->route('admin.uploaded-card-index.index')->with('warning', 'Error , contact system');

        }

    }

    public function destroy($request)
    {
        try {

            $data = UploadedCard::find($request->id);
            $url = route('admin.uploaded-card-index.index',$data->package_id);
            $deleted = $data->delete();
            return $url;
        } catch (\Exception $exception) {
            return redirect()->route('admin.uploaded-card-index.index')->with('warning', 'Error , contact system');

        }
    }
    public function destroy_selected_rows($request)
    {
        try {

            $data = UploadedCard::whereIn('id',$request->ids);
            $url = route('admin.uploaded-card-index.index',$data->first()->package_id);
            $deleted = $data->delete();
            return $url;
        } catch (\Exception $exception) {
            return redirect()->route('admin.uploaded-card-index.index')->with('warning', 'Error , contact system');

        }
    }



}
