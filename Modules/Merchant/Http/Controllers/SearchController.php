<?php

namespace Modules\Merchant\Http\Controllers;

use App\Exports\CollectionExport;
use App\Exports\SalesExport;
use App\Exports\TransferExport;
use App\Models\Merchant;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
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
        $is_inactive = $request->is_inactive;

        $query = Merchant::Order()->where('approve', 1);

        if ($username) {
            $query->where(function ($q) use ($username) {
                $q->where('name', 'like', '%' . $username . '%')
                    ->orWhere('phone', 'like', '%' . $username . '%')
                    ->orWhere('id', $username);
            });
        }

        // Get all results FIRST
        $collection = $query->get();

        // Add is_inactive flag
        $collection = $collection->map(function ($item) {
            $item->is_inactive =
                $item->last_login_at === null ||
                Carbon::parse($item->last_login_at)->lt(now()->subDays(7));
            return $item;
        });

        // Filter by inactive
        if ($is_inactive !== null && $is_inactive !== '') {
            $is_inactive_bool = $is_inactive == 1;
            $collection = $collection->filter(fn($item) => $item->is_inactive === $is_inactive_bool);
        }

        // Manual pagination
        $data = new LengthAwarePaginator(
            $collection->forPage(request('page', 1), 20),
            $collection->count(),
            20,
            request('page', 1),
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('merchant::merchants.index', compact('data', 'username', 'is_inactive'));
    }

}
