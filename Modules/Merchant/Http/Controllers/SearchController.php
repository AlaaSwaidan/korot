<?php

namespace Modules\Merchant\Http\Controllers;

use App\Exports\CollectionExport;
use App\Exports\SalesExport;
use App\Exports\TransferExport;
use App\Models\Merchant;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Maatwebsite\Excel\Facades\Excel;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function search_transfers(Request $request ,Merchant $merchant)
    {
        $data =$merchant->userable()->where('type','transfer')->Order();
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
        return view('merchant::merchants.transfers',compact('merchant','data','time','startDate','endDate'));
    }
    public function excel_transfers(Request $request){

        return Excel::download(new TransferExport($request), 'transfers_'.randNumber(4)."."."xlsx");

    }
    public function search_collections(Request $request ,Merchant $merchant)
    {
        $data =$merchant->userable()->where('type','collection')->Order();
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
        return view('merchant::merchants.collections',compact('merchant','data','time','startDate','endDate'));
    }
    public function excel_collections(Request $request){

        return Excel::download(new CollectionExport($request), 'collections_'.randNumber(4)."."."xlsx");

    }
    public function search_sales(Request $request ,Merchant $merchant)
    {
        $data =$merchant->orders()->where('parent_id','!=',null)->orderBy('id','desc');
        $startDate = $request->from_date;
        $endDate = $request->to_date;
        $time = $request->time;
        $transaction_id = $request->transaction_id;
        if ($time == "today") {
            $data = $data->whereDate('created_at', Carbon::now());
        }
        if ($time == "exact_time"){
            $startDate = Carbon::parse($request->from_date);
            $endDate = Carbon::parse($request->to_date);

            $data = $data->whereBetween(\DB::raw('DATE(created_at)'), [$startDate, $endDate]);
        }
        if ($transaction_id){
            $data = $data->where('transaction_id',$transaction_id);
        }
        $data =$data->paginate(20)->appends(request()->except('page'));
        $data->appends(['time' => $request->time,'from_date'=>$request->from_date,'to_date'=>$request->to_date]);
        return view('merchant::merchants.sales',compact('merchant','data','transaction_id','time','startDate','endDate'));
    }

    public function excel_sales(Request $request){

        return Excel::download(new SalesExport($request), 'sales_'.randNumber(4)."."."xlsx");

    }

    public function search_processes(Request $request ,Merchant $merchant)
    {
        $data =$merchant->userable() ->where('paid_order','paid')->Order();
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
        return view('merchant::merchants.processes',compact('merchant','get_data','data','time','startDate','endDate'));
    }
    public function search(Request $request)
    {
        $username = $request->username;
        $data = Merchant::Order()->where('approve',1);
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

        return view('merchant::merchants.index',compact('data','username'));


    }
}
