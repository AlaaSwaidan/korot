<?php

namespace Modules\Processes\Http\Controllers;

use App\Exports\ProcessExport;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Processes\Repositories\ProcessesRepository;

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
}
