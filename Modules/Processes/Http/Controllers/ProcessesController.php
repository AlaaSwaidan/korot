<?php

namespace Modules\Processes\Http\Controllers;

use App\Exports\ProcessExport;
use App\Filters\TransferFilters;
use App\Models\Merchant;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Processes\Repositories\ProcessesRepository;
use Modules\Transfers\Entities\Transfer;
use PDF;

class ProcessesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public $repository;
    public function __construct()
    {
        $type =\request()->type;
        if ($type == "merchants"){
            $this->middleware('permission:view_merchant_processes');
            $this->middleware('permission:export_merchant_processes', ['only' => ['excel']]);
        }elseif ($type == "distributors"){
            $this->middleware('permission:view_distributors_processes');
            $this->middleware('permission:export_distributors_processes', ['only' => ['excel']]);
        }elseif ($type == "admins"){
            $this->middleware('permission:view_admins_processes');
            $this->middleware('permission:export_admins_processes', ['only' => ['excel']]);
        }


        $this->repository = new ProcessesRepository();
    }
    public function index()
    {

        $type =\request()->type;
        $data = $this->repository->index($type);
        $name = getName($type);
        return view('processes::processes.index',compact('data','name','type'));
    }
    public function search(Request $request)
    {
        $type =$request->type;
        $from_date =$request->from_date;
        $to_date =$request->to_date;
        $time =$request->time;
        $user_name =$request->user_name;
        $process_type =$request->process_type;
        $data = $this->repository->search($request);
        $name = getName($type);
        return view('processes::processes.index',compact('data','process_type','user_name','type','name'
            ,'from_date','to_date','time'));
    }
    public function excel(Request $request){

        return Excel::download(new ProcessExport($request), 'process_'.randNumber(4)."."."xlsx");

    }
    public function pdf(Request $request)
    {
      
        $merchant = Merchant::findOrFail($request->user_id);

        $baseQuery =$merchant->userable()->where('paid_order','paid')->Order();
        TransferFilters::apply($baseQuery, $request);

        // Get list
        $data = $baseQuery->with('order')->orderByDesc('id')->get();

        // Totals (one query only)
        $totals = (clone $baseQuery)
            ->selectRaw("
            SUM(CASE WHEN type='transfer' THEN amount ELSE 0 END) AS total_transfers,
            SUM(CASE WHEN type='collection' THEN amount ELSE 0 END) AS total_collections,
            SUM(CASE WHEN type='repayment' THEN amount ELSE 0 END) AS total_repayment,
            SUM(CASE WHEN type IN ('indebtedness','payment') THEN amount ELSE 0 END) AS total_indebtedness,
            SUM(CASE WHEN type='profits' THEN amount ELSE 0 END) AS total_profits,
            SUM(CASE WHEN type='sales' THEN profits ELSE 0 END) AS total_sales_profits
        ")
            ->first();

        $html = view('merchant::pdf.processes_pdf', [
            'user'   => $merchant,
            'data'   => $data,
            'totals' => $totals,
            'time'   => $request->time,
            'type'   => $request->type,
            'from_date' => $request->from_date,
        ])->render();

        return PDF::HTML([
            'title' => 'كشف الحساب',
            'data' => $html,
            'header' => ['show' => false],
            'footer' => ['show' => false],
            'font' => 'aealarabiya',
            'font-size' => 12,
            'rtl' => true,
            'filename' => 'transactions.pdf',
            'display' => 'stream',
        ]);
    }
//    public function pdf(Request $request){
//
//        $merchant = Merchant::find($request->user_id);
//        $data = Transfer::where('userable_type',getClassModel($request->type))->Order();
//        if ($request->time == "today"){
//            $data = $data->whereDate('created_at',Carbon::now());
//        }
//        if ($request->time == "yesterday"){
//            $data = $data->whereDate('created_at',Carbon::now()->subDay());
//        }
//        if ($request->process_type ){
//            $data = $data->where('type',$request->process_type);
//        }
//        if ($request->time == "current_week"){
//            $data = $data->whereBetween('created_at',
//                [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]
//            );
//        }
//        if ($request->time == "current_month"){
//            $data = $data->whereBetween('created_at',
//                [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]
//            );
//        }
//        if ($request->time == "month_ago"){
//            $data = $data->whereMonth(
//                'created_at', '=', Carbon::now()->subMonth()->month
//            );
//        }
//        if ($request->time == "exact_time"){
//            $startDate = Carbon::parse($request->from_date);
//            $endDate = Carbon::parse($request->to_date);
//            $data = $data->whereBetween(DB::raw('DATE(created_at)'), [$startDate, $endDate]);
//        }
//        if ($request->user_name){
//            $data = $data->whereHas('user',function ($q) use($request){
//                $q->where('name', 'LIKE', "%$request->user_name%");
//            });
//        }
//        if ($request->user_id){
//            $data = $data->whereHas('user',function ($q) use($request){
//                $q->where('id', 'LIKE', "%$request->user_id%");
//            });
//        }
//        $data =$data->get();
//
//        $all_data=[
//            'data'=>$data,
//            'user'=>$merchant,
//            'time'=>$request->time,
//            'type'=>$request->type,
//            'from_date'=>$request->from_date,
//        ];
//        $html = view('merchant::pdf.processes_pdf')->with($all_data)->render();
//        $id = 'all-transactions';
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
//            'filename'=>'Invoice-'.$id.'.pdf', // filename example - invoice.pdf
//            'display'=>'stream', // stream , download , print
//        ];
//
//        return PDF::HTML($pdfarr);
//    }
}
