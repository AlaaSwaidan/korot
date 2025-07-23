<?php

namespace Modules\Company\Repositories;

use App\Models\Card;
use App\Models\Merchant;
use App\Models\Order;
use App\Models\Package;
use App\Models\Statistic;
use App\Models\Store;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\Transfers\Entities\Transfer;
use PDF;

class CardRepository
{

    public function index($package)
    {
        $data = $package->cards()->Order()->NotSold()->paginate(20)->appends(request()->except('page'));
        return $data;
    }

    public function sold()
    {
        $data = Card::Order()->Sold()->paginate(50)->appends(request()->except('page'));
        return $data;
    }
    public function generate_pdf($card)
    {

        $all_data=[
            'card'=>$card,
            'merchant_name'=>  getOrder($card) ?  getOrder($card)->merchant->name : null,
            'merchant_phone'=>  getOrder($card) ?  getOrder($card)->merchant->phone : null,
            'payment_method'=>  getOrder($card) ?  getOrder($card)->payment_method : null,
            'order'=>  getOrder($card) ?  getOrder($card) : null,
            'transaction_id'=> getTransactionId($card->card_number,$card->serial_number),
        ];

        $html = view('company::pdf.pdf_balance')->with($all_data)->render();
        $id = $card->id;
        $pdfarr = [
            'title'=>'الفاتورة ',
            'data'=>$html, // render file blade with content html
            'header'=>['show'=>false], // header content
            'footer'=>['show'=>false], // Footer content
            'font'=>'aealarabiya', //  dejavusans, aefurat ,aealarabiya ,times
            'font-size'=>12, // font-size
            'text'=>'', //Write
            'rtl'=>true, //true or false
            'creator'=>'Korot', // creator file - you can remove this key
            'keywords'=>$id , // keywords file - you can remove this key
            'subject'=>'Invoice', // subject file - you can remove this key
            'filename'=>'Invoice-'.$id.'.pdf', // filename example - invoice.pdf
            'display'=>'stream', // stream , download , print
        ];

        return PDF::HTML($pdfarr);
    }
    public function package_sold_cards($package)
    {
        $data = Card::where('package_id',$package->id)->Order()->Sold()->paginate(30)->appends(request()->except('page'));
        return $data;
    }
    public function most_seller_cards($request)
    {
        $countedRows = Card::groupBy('package_id')
            ->where('sold',1)
            ->select('package_id', DB::raw('count(*) as total'))
            ->orderBy('total', 'desc');
        if($request->from_date && $request->to_date == null){
            $countedRows = $countedRows->whereDate('updated_at',$request->from_date);
        }if($request->from_date && $request->to_date){
        $countedRows = $countedRows->whereBetween(DB::raw('DATE(updated_at)'), [$request->from_date, $request->to_date]);
        }

        $countedRows = $countedRows->paginate(30)->appends(request()->except('page'));
        return $countedRows;
    }
    public function lowest_seller_cards()
    {
        $countedRows = Card::groupBy('package_id')
            ->where('sold',1)
            ->select('package_id', DB::raw('count(*) as total'))
            ->orderBy('total', 'asc')
            ->paginate(30);
        return $countedRows;
    }

    public function store($request,$package)
    {
        try {
            $request['package_id']=$package->id;
            $request['cart_type']="inserted";
            $card = Card::create($request->all());
            $statistics = Statistic::find(1);
            $statistics->update([
                'card_numbers'=>$statistics->card_numbers + 1
            ]);
            return $card;
        } catch (\Exception $exception) {
            return redirect()->route('admin.cards.index')->with('warning', 'Error , contact system');
        }
    }

    public function update($request, $card)

    {
        try {
            $updated = $card->update($request->all());

            return $updated;
        } catch (\Exception $exception) {
            return redirect()->route('admin.cards.index')->with('warning', 'Error , contact system');

        }

    }
    public function restore_sold_card($request)
    {
        try {

            $data = Card::find($request->id);
            $data->update([
                'sold'=>0
            ]);
            $order = Order::where('card_number',$data->card_number)->where('serial_number',$data->serial_number)
                ->where('package_id',$data->package_id)->first();
//            $newOrder = $order->replicate();
//            $newOrder->created_at = Carbon::now();
//            $newOrder->save();
            $transfer = Transfer::where('order_id',$order->id)->first();
            $merchant = Merchant::find($order->merchant_id);
            $newTransfer = $transfer->replicate();
            $newTransfer->type = "restore";
            $newTransfer->profits = 0;
            $newTransfer->profits_total = $merchant->profits - ($transfer->amount - $order->merchant_price);
            $newTransfer->balance_total = $merchant->balance + $transfer->amount;;
            $newTransfer->created_at = Carbon::now();
            $newTransfer->save();
            updateTransfer($newTransfer,$merchant);
            $merchant->update([
                'balance'=>$merchant->balance + $transfer->amount,
                'sales'=>$merchant->sales - $transfer->amount,
                'profits'=>$merchant->profits - ($transfer->amount - $order->merchant_price),
            ]);
            $url = route('admin.sold-cards.index');
//            $statistics = Statistic::find(1);
//            $statistics->update([
//                'card_numbers'=>$statistics->card_numbers + 1
//            ]);
            return $url;
        } catch (\Exception $exception) {
            return redirect()->route('admin.sold-cards.index')->with('warning', 'Error , contact system');

        }
    }
    public function destroy($request)
    {
        try {

            $data = Card::find($request->id);
            $url = route('admin.cards.index',$data->package_id);
            $deleted = $data->delete();
            $statistics = Statistic::find(1);
            $statistics->update([
                'card_numbers'=>$statistics->card_numbers - 1
            ]);
            return $url;
        } catch (\Exception $exception) {
            return redirect()->route('admin.cards.index')->with('warning', 'Error , contact system');

        }
    }
    public function delete_all_store($request)
    {
        try {

            $data = Card::where('sold', 0)->where('package_id',$request->package);
            $statistics = Statistic::find(1);
            $statistics->update([
                'card_numbers'=>$statistics->card_numbers - $data->count()
            ]);
            $deleted = $data->delete();
            return $deleted;
        } catch (\Exception $exception) {
            return redirect()->route('admin.cards.index')->with('warning', 'Error , contact system');

        }
    }
    public function destroy_selected_rows($request)
    {
        try {

            $data = Card::whereIn('id',$request->ids);
            $url = route('admin.cards.index',$data->first()->package_id);
            $statistics = Statistic::find(1);
            $statistics->update([
                'card_numbers'=>$statistics->card_numbers - $data->count()
            ]);
            $deleted = Card::whereIn('id',$request->ids)->delete();

            return $url;
        } catch (\Exception $exception) {
            return redirect()->route('admin.cards.index')->with('warning', 'Error , contact system');

        }
    }



}
