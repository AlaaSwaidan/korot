<?php

namespace Modules\Admin\Http\Controllers;

use App\Exports\AdminCollectionExport;
use App\Exports\AdminRepaymentExport;
use App\Exports\AdminTransferExport;
use App\Exports\CollectionExport;
use App\Exports\DistributorTransferExport;
use App\Exports\TransferExport;
use App\Models\Admin;
use App\Models\Distributor;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Transfers\Entities\Transfer;

class SearchController extends Controller
{

    public function search_transfers(Request $request ,Admin $admin)
    {
        $type = $request->type_transfers;
        if ($request->type_transfers == "from_dis"){
            $type = "from_dis_transfers";
            $data =$admin->providerable()->where('type','transfer')->Order();
        }else{
            $type = "super";
            $data =$admin->userable()->where('type','transfer')->Order();
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
        $total_transfers = $transfer->sum('amount');
        $data =$data->paginate(20)->appends(request()->except('page'));
        $data->appends(['time' => $request->time,'type_transfers' => $request->type_transfers,'from_date'=>$request->from_date,'to_date'=>$request->to_date]);
        if ($request->type_transfers == "from_dis"){
            return view('admin::admins.transfers_to_dis',compact('admin','type','data','time','startDate','endDate','total_transfers'));

        }else{
            return view('admin::admins.transfers',compact('admin','type','data','time','startDate','endDate','total_transfers'));

        }
    }
    public function search_repayments(Request $request ,Admin $admin)
    {
        $data =$admin->providerable()->where('type','repayment')->Order();
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
        $repayment = clone $data;
        $total_repayment = $repayment->sum('amount');
        $data =$data->paginate(20)->appends(request()->except('page'));
        $data->appends(['time' => $request->time,'from_date'=>$request->from_date,'to_date'=>$request->to_date]);
        return view('admin::admins.repayments',compact('admin','data','time','startDate','endDate','total_repayment'));
    }
    public function search_collections(Request $request ,Admin $admin)
    {
        $type = $request->type_collection;
        if ($request->type_collection == "from_dis"){
            $data =$admin->providerable()->where('type','collection')->Order();
        }else{
            $type = "super-collection";
            $data =$admin->userable()->where('type','collection')->Order();
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
        $collection = clone $data;
        $total_collection = $collection->sum('amount');
        $data =$data->paginate(20)->appends(request()->except('page'));
        $data->appends(['time' => $request->time,'type_collection' => $request->type_collection,'from_date'=>$request->from_date,'to_date'=>$request->to_date]);
        if ($request->type_collection == "from_dis"){
            return view('admin::admins.collections_from_dis',compact('admin','data','time','startDate','type','endDate','total_collection'));

        }else{
            return view('admin::admins.collections',compact('admin','data','time','startDate','type','endDate','total_collection'));

        }
    }


    public function search_process(Request $request ,Admin $admin)
    {
        $data =Transfer::where(function ($q) use($admin){
            $q->where(function ($q1)use($admin){
                $q1->where('providerable_type','App\Models\Admin')->where('providerable_id',$admin->id);
            });
            $q->orWhere(function ($q2)use($admin){
                $q2->where('userable_type','App\Models\Admin')->where('userable_id',$admin->id);
            });
        })->Order();
//        $data =$admin->userable()->Order();
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
        return view('admin::admins.processes',compact('admin','get_data','data','time','startDate','endDate'));
    }
    public function excel_transfers(Request $request){

        return Excel::download(new AdminTransferExport($request), 'transfers_'.randNumber(4)."."."xlsx");

    }
    public function excel_collection(Request $request){

        return Excel::download(new AdminCollectionExport($request), 'transfers_'.randNumber(4)."."."xlsx");

    }
    public function excel_repayment(Request $request){

        return Excel::download(new AdminRepaymentExport($request), 'transfers_'.randNumber(4)."."."xlsx");

    }
    public function search_admins(Request $request)
    {
        $username = $request->username;
        $data = Admin::where('type', 'admin')->Order();
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

      return view('admin::admins.index',compact('data','username'));


    }
}
