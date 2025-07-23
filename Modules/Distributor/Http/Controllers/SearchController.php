<?php

namespace Modules\Distributor\Http\Controllers;

use App\Exports\CollectionExport;
use App\Exports\DistributorMerchantExport;
use App\Exports\DistributorTransferExport;
use App\Exports\TransferExport;
use App\Models\Distributor;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Transfers\Entities\Transfer;
use PDF ;

class SearchController extends Controller
{

    public function search_transfers(Request $request ,Distributor $distributor)
    {
        $data =$distributor->userable()->where('type','transfer')->Order();
        $startDate = $request->from_date;
        $endDate = $request->to_date;
        $time = $request->time;
        if ($time == "today") {
            $data = $data->whereDate('created_at', Carbon::now());
        }
        if ($time == "exact_time"){
            $startDate = Carbon::parse($request->from_date);
            $endDate = Carbon::parse($request->to_date);

            $data = $data->whereBetween(\DB::raw('DATE(created_at)'), [$startDate, $endDate]);
        }
        $data =$data->paginate(20)->appends(request()->except('page'));
        $data->appends(['time' => $request->time,'from_date'=>$request->from_date,'to_date'=>$request->to_date]);
        $ids = $distributor->merchants()->pluck('merchants.id')->toArray();
        $sales_merchant_wallet = Order::where('parent_id',null)->where('paid_order',"paid")->whereIn('merchant_id',$ids)->where('payment_method','wallet')->sum('card_price');
        $sales_merchant_geadia = Order::where('parent_id',null)->where('paid_order',"paid")->whereIn('merchant_id',$ids)->where('payment_method','online')->sum('card_price');
        return view('distributor::distributors.transfers',compact('distributor','data','time','startDate','endDate','sales_merchant_geadia','sales_merchant_wallet'));
    }
    public function search_by_merchants(Request $request , Distributor $distributor)
    {
        $data =Transfer::orderBy('id','desc')->where('type',$request->transfer_type)->where('providerable_type','App\Models\Distributor')
            ->where('providerable_id',$distributor->id)->where('confirm',1);
        $merchant_name = $request->merchant_name;
        if($request->merchant_name ){
            $data = $data->whereHas('merchant',function ($q) use($merchant_name){
                $q->where('name', 'LIKE', "%$merchant_name%");
                $q->orWhere('name', 'LIKE', "%$merchant_name%");
            });
        }

        $data =$data->paginate(20);
        $ids = $distributor->merchants()->pluck('merchants.id')->toArray();
        $sales_merchant_wallet = Order::where('parent_id',null)->where('paid_order',"paid")->whereIn('merchant_id',$ids)->where('payment_method','wallet')->sum('card_price');
        $sales_merchant_geadia = Order::where('parent_id',null)->where('paid_order',"paid")->whereIn('merchant_id',$ids)->where('payment_method','online')->sum('card_price');
        if ($request->transfer_type == "transfer"){
            return view('distributor::my_profile.transfers_to_merchants',compact('distributor','data','merchant_name','sales_merchant_wallet','sales_merchant_geadia'));

        }else{
            return view('distributor::my_profile.collect_from_merchants',compact('distributor','data','sales_merchant_geadia','sales_merchant_wallet'));
        }
    }
    public function search_by_distributors_process(Request $request , Distributor $distributor)
    {
        $data =Transfer::orderBy('id','desc')->where('providerable_type','App\Models\Distributor')
            ->where('providerable_id',$distributor->id)->where('confirm',1);
        $merchant_name = $request->merchant_name;
        if($request->merchant_name ){
            $data = $data->whereHas('merchant',function ($q) use($merchant_name){
                $q->where('name', 'LIKE', "%$merchant_name%");
                $q->orWhere('name', 'LIKE', "%$merchant_name%");
            });
        }
        $startDate = $request->from_date;
        $endDate = $request->to_date;
        $time = $request->time;
        if ($time == "today") {
            $data = $data->whereDate('created_at', Carbon::now());
        }
        if ($time == "exact_time"){
            $startDate = Carbon::parse($request->from_date);
            $endDate = Carbon::parse($request->to_date);

            $data = $data->whereBetween(\DB::raw('DATE(created_at)'), [$startDate, $endDate]);
        }
        $transfer = clone $data;
        $collection = clone $data;
        $total_transfers = $transfer->where('type','transfer')->sum('amount');
        $total_collection = $collection->where('type','collection')->sum('amount');
        $data =$data->paginate(20);
        $ids = $distributor->merchants()->pluck('merchants.id')->toArray();
        $sales_merchant_wallet = Order::where('parent_id',null)->where('paid_order',"paid")->whereIn('merchant_id',$ids)->where('payment_method','wallet')->sum('card_price');
        $sales_merchant_geadia = Order::where('parent_id',null)->where('paid_order',"paid")->whereIn('merchant_id',$ids)->where('payment_method','online')->sum('card_price');
        return view('distributor::my_profile.process_for_distributors_merchants',compact('distributor','total_transfers','total_collection','data','startDate','endDate','merchant_name','sales_merchant_wallet','sales_merchant_geadia'));

    }
    public function search_by_distributors_merchants_sales(Request $request , Distributor $distributor)
    {
        $payment = $request->payment;
        $ids = $distributor->merchants()->pluck('merchants.id')->toArray();
        $sales_merchant_wallet = Order::where('parent_id','!=',null)->where('paid_order',"paid")->whereIn('merchant_id',$ids)->where('payment_method','wallet');
        $sales_merchant_geadia = Order::where('parent_id','!=',null)->where('paid_order',"paid")->whereIn('merchant_id',$ids)->where('payment_method','online');
        $sales_merchant = Order::where('parent_id','!=',null)->where('paid_order',"paid")->whereIn('merchant_id',$ids);

        $startDate = $request->from_date;
        $endDate = $request->to_date;



        $startDate = Carbon::parse($request->from_date);
        $endDate = Carbon::parse($request->to_date);

        $sales_merchant_wallet = $sales_merchant_wallet->whereBetween(\DB::raw('DATE(created_at)'), [$startDate, $endDate]);
        $sales_merchant_geadia = $sales_merchant_geadia->whereBetween(\DB::raw('DATE(created_at)'), [$startDate, $endDate]);
        $sales_merchant = $sales_merchant->whereBetween(\DB::raw('DATE(created_at)'), [$startDate, $endDate]);

        $sales_merchant_geadia= $sales_merchant_geadia->sum('card_price');
        $sales_merchant_wallet= $sales_merchant_wallet->sum('card_price');
        $sales_merchant = $sales_merchant->sum('card_price');


        return view('distributor::distributors.show',compact('distributor','payment','sales_merchant','startDate','endDate','sales_merchant_wallet','sales_merchant_geadia'));

    }

    public function generate_pdf(Request $request, Distributor $distributor)
    {
        // 1) Parse the incoming dates and include the full day (00:00:00 -> 23:59:59)
        $startDate = Carbon::parse($request->from_date)->startOfDay();
        $endDate   = Carbon::parse($request->to_date)->endOfDay();

        // 2) Retrieve merchants once and then pluck their IDs
        //    This saves one query, rather than calling `->get()` and `->pluck()` separately.
        //    Also, only add orderBy('id','desc') if it’s actually needed for your view.
        $merchants = $distributor
            ->merchants()
            ->whereHas('orders')          // only merchants having orders
            ->orderBy('id', 'desc')
            ->get();

        $merchantsIds = $merchants->pluck('id')->toArray();

        // 3) Build a base query for orders within the date range:
        //    - Use `whereBetween('created_at', [...])` instead of applying DATE() on the column
        //      so MySQL can use any indexes on `created_at`.
        //    - Avoid separate queries for each total; use grouping where possible.
        $ordersQuery = Order::whereIn('merchant_id', $merchantsIds)
            ->whereNotNull('parent_id')
            ->where('paid_order', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate]);

        // 4) Get partial sums grouped by payment_method in ONE query
        //    This returns an array keyed by payment_method with sum of card_price.
        $totals = $ordersQuery
            ->selectRaw('payment_method, SUM(card_price) as total')
            ->groupBy('payment_method')
            ->pluck('total', 'payment_method');

        // 5) Overall sum (with no restriction on payment_method)
        $all_total = $ordersQuery->sum('card_price');

        // 6) Extract the “online” and “wallet” sums from $totals
        $online_total = $totals['online'] ?? 0;
        $wallet_total = $totals['wallet'] ?? 0;

        // 7) Prepare data for the PDF view
        $all_data = [
            'data'          => $merchants,
            'distributor'   => $distributor,
            'online_total'  => $online_total,
            'wallet_total'  => $wallet_total,
            'all_total'     => $all_total,
            'from_date'     => $startDate->format('Y-m-d'),
            'to_date'       => $endDate->format('Y-m-d'),
            'startDate'     => $startDate,
            'endDate'       => $endDate,
        ];

        // 8) Render the Blade view into HTML
        $html = view('distributor::pdf.pdf_distributor', $all_data)->render();

        // 9) Generate the PDF
        $id = $distributor->id;
        $pdfarr = [
            'title'     => 'الفاتورة',
            'data'      => $html,
            'header'    => ['show' => false],
            'footer'    => ['show' => false],
            'font'      => 'aealarabiya', // (Could be 'dejavusans', etc.)
            'font-size' => 12,
            'text'      => '',
            'rtl'       => true,
            'creator'   => 'Korot',
            'keywords'  => $id,
            'subject'   => 'Invoice',
            'filename'  => 'DistributorMerchantSales-' . $id . '.pdf',
            'display'   => 'stream', // or 'download'/'print'
        ];

        return PDF::HTML($pdfarr);
    }

//    public  function generate_pdf(Request $request , Distributor $distributor) {
//        $merchants = $distributor->merchants()->orderBy('id','desc')->whereHas('orders')->get();
//        $merchantsIds = $distributor->merchants()->orderBy('id','desc')->whereHas('orders')->pluck('merchants.id')->toArray();
//
//
//        $startDate = Carbon::parse($request->from_date);
//        $endDate = Carbon::parse($request->to_date);
//        $online_total = Order::whereIn('merchant_id',$merchantsIds)->where('parent_id','!=',null)->where('paid_order',"paid")->where('payment_method','online')->whereBetween(\DB::raw('DATE(created_at)'), [$startDate, $endDate])->sum('card_price');
//        $wallet_total = Order::whereIn('merchant_id',$merchantsIds)->where('parent_id','!=',null)->where('paid_order',"paid")->where('payment_method','wallet')->whereBetween(\DB::raw('DATE(created_at)'), [$startDate, $endDate])->sum('card_price');
//        $all_total = Order::whereIn('merchant_id',$merchantsIds)->where('parent_id','!=',null)->where('paid_order',"paid")->whereBetween(\DB::raw('DATE(created_at)'), [$startDate, $endDate])->sum('card_price');
//
//        $all_data=[
//            'data'=>$merchants,
//            'distributor'=>$distributor,
//            'online_total'=>$online_total,
//            'wallet_total'=>$wallet_total,
//            'all_total'=>$all_total,
//            'from_date'=>Carbon::parse($request->from_date)->format('Y-m-d'),
//            'to_date'=>Carbon::parse($request->to_date)->format('Y-m-d'),
//            'startDate'=>$startDate,
//            'endDate'=>$endDate,
//        ];
//
//        $html = view('distributor::pdf.pdf_distributor')->with($all_data)->render();
//        $id = $distributor->id;
//        $pdfarr = [
//            'title'=>'الفاتورة ',
//            'data'=>$html, // render file blade with content html
//            'header'=>['show'=>false], // header content
//            'footer'=>['show'=>false], // Footer content
//            'font'=>'aealarabiya', //  dejavusans, aefurat ,aealarabiya ,times
//            'font-size'=>12, // font-size
//            'text'=>'', //Write
//            'rtl'=>true, //true or false
//            'creator'=>'Korot', // creator file - you can remove this key
//            'keywords'=>$id , // keywords file - you can remove this key
//            'subject'=>'Invoice', // subject file - you can remove this key
//            'filename'=>'DistributorMerchantSales-'.$id.'.pdf', // filename example - invoice.pdf
//            'display'=>'stream', // stream , download , print
//        ];
//
//        return PDF::HTML($pdfarr);
//
//    }
    public function excel_transfers(Request $request){

        return Excel::download(new TransferExport($request), 'transfers_'.randNumber(4)."."."xlsx");

    }
    public function transfers_collect_to_merchants_excel(Request $request){

        return Excel::download(new DistributorTransferExport($request), 'transfers_'.randNumber(4)."."."xlsx");

    }
    public function distributor_merchants_excel(Request $request){

        return Excel::download(new DistributorMerchantExport($request), 'distributors_merchants_'.randNumber(4)."."."xlsx");

    }
    public function search_collections(Request $request ,Distributor $distributor)
    {
        $data =$distributor->userable()->where('type','collection')->Order();
        $startDate = $request->from_date;
        $endDate = $request->to_date;
        $time = $request->time;
        if ($time == "today") {
            $data = $data->whereDate('created_at', Carbon::now());
        }
        if ($time == "exact_time"){
            $startDate = Carbon::parse($request->from_date);
            $endDate = Carbon::parse($request->to_date);

            $data = $data->whereBetween(\DB::raw('DATE(created_at)'), [$startDate, $endDate]);
        }
        $data =$data->paginate(20)->appends(request()->except('page'));
        $data->appends(['time' => $request->time,'from_date'=>$request->from_date,'to_date'=>$request->to_date]);
        $ids = $distributor->merchants()->pluck('merchants.id')->toArray();
        $sales_merchant_wallet = Order::where('parent_id',null)->where('paid_order',"paid")->whereIn('merchant_id',$ids)->where('payment_method','wallet')->sum('card_price');
        $sales_merchant_geadia = Order::where('parent_id',null)->where('paid_order',"paid")->whereIn('merchant_id',$ids)->where('payment_method','online')->sum('card_price');
        return view('distributor::distributors.collections',compact('distributor','data','time','startDate','endDate','sales_merchant_geadia','sales_merchant_wallet'));
    }

    public function excel_collections(Request $request){

        return Excel::download(new CollectionExport($request), 'collections_'.randNumber(4)."."."xlsx");

    }
    public function search_process(Request $request ,Distributor $distributor)
    {
        $data =$distributor->userable()->Order();
        $get_data = clone $data;
        $startDate = $request->from_date;
        $endDate = $request->to_date;
        $time = $request->time;
        if ($time == "today") {
            $data = $data->whereDate('created_at', Carbon::now());
        }
        if ($time == "exact_time"){
            $startDate = Carbon::parse($request->from_date);
            $endDate = Carbon::parse($request->to_date);

            $data = $data->whereBetween(\DB::raw('DATE(created_at)'), [$startDate, $endDate]);
        }
        $data =$data->paginate(20)->appends(request()->except('page'));
        $data->appends(['time' => $request->time,'from_date'=>$request->from_date,'to_date'=>$request->to_date]);
        $ids = $distributor->merchants()->pluck('merchants.id')->toArray();
        $sales_merchant_wallet = Order::where('parent_id',null)->where('paid_order',"paid")->whereIn('merchant_id',$ids)->where('payment_method','wallet')->sum('card_price');
        $sales_merchant_geadia = Order::where('parent_id',null)->where('paid_order',"paid")->whereIn('merchant_id',$ids)->where('payment_method','online')->sum('card_price');
        return view('distributor::distributors.processes',compact('distributor','get_data','data','time','startDate','endDate','sales_merchant_geadia','sales_merchant_wallet'));
    }
    public function search_orders_transaction(Request $request ,Distributor $distributor)
    {
        $ids = $distributor->merchants()->pluck('merchants.id')->toArray();
        $data =Order::where('parent_id',null)->where('paid_order',"paid")->orderBy('id','desc')->whereIn('merchant_id',$ids);
        $get_data = clone $data;
        $transaction_id =$request->transaction_id;
        if ($transaction_id ) {
            $data = $data->where('transaction_id', $transaction_id);
        }

        $data =$data->paginate(20)->appends(request()->except('page'));
        $data->appends(['time' => $request->time,'from_date'=>$request->from_date,'to_date'=>$request->to_date]);
        $ids = $distributor->merchants()->pluck('merchants.id')->toArray();
        $sales_merchant_wallet = Order::where('parent_id',null)->where('paid_order',"paid")->whereIn('merchant_id',$ids)->where('payment_method','wallet')->sum('card_price');
        $sales_merchant_geadia = Order::where('parent_id',null)->where('paid_order',"paid")->whereIn('merchant_id',$ids)->where('payment_method','online')->sum('card_price');
        return view('distributor::my_profile.sales_distributors_merchants',compact('distributor','get_data','data','transaction_id','sales_merchant_geadia','sales_merchant_wallet'));
    }
    public function search(Request $request)
    {
        $username = $request->username;
        $data = Distributor::Order();
        if ($username ) {
            $data= $data->where(function ($q) use ($request) {
                $q->where('name', 'like', $request->username . '%')
                    ->orWhere('name', 'like', '%' . $request->username . '%');
                $q->orWhere('phone', 'like', $request->username . '%')
                    ->orWhere('phone', 'like', '%' . $request->username . '%');
                $q->orWhere('id', '=', $request->username);

            });
        }

        $data =$data->paginate(20)->appends(request()->except('page'));
        $data->appends(['username'=>$request->username]);

        return view('distributor::distributors.index',compact('data','username'));


    }
    public function reports(Request $request)
    {
        return view('distributor::distributors.reports');

    }
    public  function generate_distributors_pdf(Request $request ) {


        // Fetch all distributors
        $distributors = Distributor::all();

        $result = [];

// Example of request dates (replace with actual input)
        $from_date = $request->from_date ?? null;
        $to_date = $request->to_date ?? null;

// Totals for all distributors combined
        $total_online_all = 0;
        $total_wallet_all = 0;

        foreach ($distributors as $distributor) {
            // Base query for orders under the distributor
            $query = Order::join('merchants', 'orders.merchant_id', '=', 'merchants.id')
                ->where('merchants.distributor_id', $distributor->id) // Filter by distributor
                ->where('orders.paid_order', 'paid') // Only paid orders
                ->where('orders.parent_id', '!=', null);
            // Apply date filtering if provided
            if ($from_date && $to_date) {
                $query->whereDate('orders.updated_at', '>=', $from_date)
                    ->whereDate('orders.updated_at', '<=', $to_date);
            } elseif ($from_date) {
                $query->whereDate('orders.updated_at', '=', $from_date);
            }

            // Aggregate totals
            $totals = $query->selectRaw("
                COALESCE(SUM(CASE WHEN orders.payment_method = 'online' THEN orders.card_price ELSE 0 END), 0) as total_online,
                COALESCE(SUM(CASE WHEN orders.payment_method = 'wallet' THEN orders.card_price ELSE 0 END), 0) as total_wallet
            ")->first();

            // Store distributor-specific results
            $result[] = [
                'distributor_id'   => $distributor->id,
                'distributor_name' => $distributor->name,
                'total_online'     => $totals->total_online ?? 0,
                'total_wallet'     => $totals->total_wallet ?? 0,
            ];

            // Update overall totals
            $total_online_all += (float) ($totals->total_online ?? 0);
            $total_wallet_all += (float) ($totals->total_wallet ?? 0);

        }
        /*=========*/


        $startDate = Carbon::parse($request->from_date);
        $endDate = Carbon::parse($request->to_date);

        $all_data=[
            'data'=>$result,
            'online_total'=>$total_online_all,
            'wallet_total'=>$total_wallet_all,
            'all_total'=>$total_wallet_all + $total_online_all,
            'from_date'=>Carbon::parse($request->from_date)->format('Y-m-d'),
            'to_date'=>Carbon::parse($request->to_date)->format('Y-m-d'),
            'startDate'=>$startDate,
            'endDate'=>$endDate,
        ];

        $html = view('distributor::pdf.pdf_all_distributor')->with($all_data)->render();
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
            'keywords'=>'all-distributor' , // keywords file - you can remove this key
            'subject'=>'Invoice', // subject file - you can remove this key
            'filename'=>'DistributorMerchantSales-all-distributors'.'.pdf', // filename example - invoice.pdf
            'display'=>'download', // stream , download , print
        ];

        return PDF::HTML($pdfarr);

    }
}
