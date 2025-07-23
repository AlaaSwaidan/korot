<?php

namespace Modules\Reports\Http\Controllers;

use App\Exports\AllReportsExport;
use App\Models\Bank;
use App\Models\Journal;
use App\Models\Outgoing;
use App\Models\PurchaseOrder;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Transfers\Entities\Transfer;

class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function __construct()
    {

        $this->middleware('permission:view_all_reports');
        $this->middleware('permission:export_all_reports', ['only' => ['excel']]);

    }
    public function index(Request $request)
    {
        $from_date =$request->from_date;
        $to_date =$request->to_date;
        $today = "";
        $outgoing = Outgoing::Order();
        $journals = Journal::Order();
        $invoices = PurchaseOrder::Order()->where('confirm',1);
        $data = Transfer::orderBy('id','desc');
        $banks = Bank::get();
        if ($request->from_date && $request->to_date){
            $startDate = Carbon::parse($request->from_date);
            $endDate = Carbon::parse($request->to_date);

            $outgoing = $outgoing->whereBetween(\DB::raw('DATE(created_at)'), [$startDate, $endDate])->get();
            $journals = $journals->whereBetween(\DB::raw('DATE(created_at)'), [$startDate, $endDate])->get();
            $invoices = $invoices->whereBetween(\DB::raw('DATE(created_at)'), [$startDate, $endDate])->get();
            $data = $data->whereBetween(\DB::raw('DATE(created_at)'), [$startDate, $endDate])->get();

//            $data =$data->whereBetween(\DB::raw('DATE(created_at)'), [$startDate, $endDate])
//                ->get()
//                ->groupBy('bank_id');


            $today =' التاريخ '.$startDate->format('Y-m-d').' الى '.$endDate->format('Y-m-d');
        }else{
            $journals = $journals->get();
        }
        return view('reports::reports.index',compact('data','from_date','to_date','today','banks','invoices','outgoing','journals'));
    }
    public function excel(Request $request){
        $outgoing = Outgoing::Order();
        $journals = Journal::Order();
        $invoices = PurchaseOrder::Order()->where('confirm',1);
        $data = Transfer::orderBy('id','desc');
        $all_banks = Bank::get();
        if ($request->from_date && $request->to_date){
            $startDate = Carbon::parse($request->from_date);
            $endDate = Carbon::parse($request->to_date);

            $outgoing = $outgoing->whereBetween(\DB::raw('DATE(created_at)'), [$startDate, $endDate])->get();
            $journals = $journals->whereBetween(\DB::raw('DATE(created_at)'), [$startDate, $endDate])->get();
            $invoices = $invoices->whereBetween(\DB::raw('DATE(created_at)'), [$startDate, $endDate])->get();
            $data = $data->whereBetween(\DB::raw('DATE(created_at)'), [$startDate, $endDate])->get();

//            $data =$data->whereBetween(\DB::raw('DATE(created_at)'), [$startDate, $endDate])
//                ->get()
//                ->groupBy('bank_id');


            $today =' التاريخ '.$startDate->format('Y-m-d').' الى '.$endDate->format('Y-m-d');
        }else{
            $journals = $journals->get();
        }

        $report = [['اجمالي المبيعات', 'اجمالي المشتريات', 'اجمالي المصروفات','اجمالي الارباح']];
        array_push($report, [
            $data->where('type','sales')->sum('amount'),
            $invoices->sum('total_after_tax'),
            $outgoing->sum('total'),
            $data->where('type','profits')->sum('amount') + $data->where('type','sales')->sum('profits'),
        ]);
        foreach ($all_banks as $bank){
            array_push($report[0],$bank->name['ar']);
            array_push($report[1],$journals->where('bank_id',$bank->id)->where('type','collection')->sum('credit') -
                ($journals->where('bank_id',$bank->id)->where('type','purchases')->sum('debit') +
                    $journals->where('bank_id',$bank->id)->where('type','outgoings')->sum('debit')));


        }

        return Excel::download(new AllReportsExport($report), 'Items report from ' . $request->from_date . ' to ' .$request->to_date . '.xlsx');

    }

}
