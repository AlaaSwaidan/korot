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
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Transfers\Entities\Transfer;

class AllReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function __construct()
    {

//        $this->middleware('permission:view_all_reports');
//        $this->middleware('permission:export_all_reports', ['only' => ['excel']]);

    }
    public function index(Request $request)
    {
        $from_date =$request->from_date;
        $to_date =$request->to_date;
        $type = $request->type;
        $time = $request->time;
        $user_type = $request->user_type;
        $username = $request->username;
        $total = "";
        $users=[];
        $data = Transfer::where('type',$type)->orderBy('id','desc');

        if ($request->time == "today"){
            $data = $data->whereDate('created_at',Carbon::now());
            $total = $data->sum('amount');
        }
        if ($request->time == "current_week"){
            $data = $data->whereBetween('created_at',
                [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]
            );
            $total = $data->sum('amount');
        }
        if ($user_type){
            $data = $data->where('userable_type',$user_type);
            $class = $user_type;
            if ($user_type){
                $users = $class::orderBy('id','desc')->get();
                if($username)  $data = $data->where('userable_id',$username);

            }
            $total = $data->sum('amount');
        }
        if ($request->time == "current_month"){
            $data = $data->whereBetween('created_at',
                [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]
            );
            $total = $data->sum('amount');
        }
        if ($request->time == "exact_time"){
            $from_date = Carbon::parse($request->from_date);
            $to_date = Carbon::parse($request->to_date);
            $data = $data->whereBetween(DB::raw('DATE(created_at)'), [$from_date, $to_date]);
            $total = $data->sum('amount');
        }
        $data =$data->paginate(20)->appends(request()->except('page'));
        $data->appends(['time' => $request->time,'from_date'=>$request->from_date,'to_date'=>$request->to_date,'user_type'=>$user_type,'username'=>$username]);

        return view('reports::search.index',compact('data','users','from_date','to_date','time','type','total','user_type','username'));
    }
    public function all_users(Request $request)
    {
        $class = $request->class_name;
        $users = $class::orderBy('id','desc')->get();

        $data['users']= $users;
        return json_encode($data);
    }

}
