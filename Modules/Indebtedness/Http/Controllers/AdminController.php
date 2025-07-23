<?php

namespace Modules\Indebtedness\Http\Controllers;

use App\Models\Admin;
use App\Models\Distributor;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Collections\Http\Requests\CollectionRequest;
use Modules\Collections\Repositories\CollectionAdminRepository;
use Modules\Collections\Repositories\CollectionRepository;
use Modules\Indebtedness\Http\Requests\IndebtednessRequest;
use Modules\Indebtedness\Repositories\IndebtednessAdminRepository;
use Modules\Indebtedness\Repositories\IndebtednessRepository;
use Modules\Transfers\Entities\Transfer;

class AdminController extends Controller
{
    public $repository;
    public $repositoryCollection;
    public function __construct()
    {
        $this->middleware('permission:createIndebtedness_admins_repayment', ['only' => ['add_indebtedness', 'store_indebtedness']]);
        $this->middleware('permission:createRepayment_admins_repayment', ['only' => ['add_repayment', 'store_repayment']]);
        $this->middleware('permission:show_admins_repayment', ['only' => ['view_indebtedness']]);
        $this->repository = new IndebtednessAdminRepository();
        $this->repositoryIndebtedness = new IndebtednessRepository();
    }
    public function view_indebtedness( Admin $admin)
    {
        $type = 'admins';
        $name = getName($type);
        $data = $this->repositoryIndebtedness->index($admin);
        return view('indebtedness::admins.view_indebtedness',compact('admin','data','type','name'));
    }
    public function generate_pdf(Transfer $transfer)
    {

        $pdf = $this->repositoryIndebtedness->generate_pdf($transfer,'admins');
        return $pdf;

    }
    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */

    public function add_indebtedness(Request $request,Admin $admin)
    {
        $type = $request->type;
        return view('indebtedness::admins.add_indebtedness',compact('admin','type'));
    }
    public function add_repayment(Request $request,Admin $admin)
    {
        $type = $request->type;
        return view('indebtedness::admins.add_repayment',compact('admin','type'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store_indebtedness(IndebtednessRequest $request,Admin $admin)
    {
        $data = $this->repository->store_indebtedness($request,$admin);
        return $data ?
            redirect()->route('admin.indebtedness.index','type=admins')->with('success', trans('messages.addOK')) :
            redirect()->route('admin.indebtedness.index','type=admins')->with('danger', "رصيدك لا يكفي للتحويل");
    }
    public function store_repayment(IndebtednessRequest $request,Admin $admin)
    {
        $data = $this->repository->store_repayment($request,$admin);
        return $data ?
            redirect()->route('admin.indebtedness.index','type=admins')->with('success', trans('messages.addOK')) :
            redirect()->route('admin.indebtedness.index','type=admins')->with('danger', "رصيدك لا يكفي للتحويل");
    }
    public function search(Request $request,Admin $admin)
    {
        $type =$request->type;
        $from_date =$request->from_date;
        $to_date =$request->to_date;
        $time =$request->time;
        $data = $this->repositoryIndebtedness->search($request, $admin);
        $name = getName($type);
        return view('indebtedness::admins.view_indebtedness',compact('data','admin','type','name'
            ,'from_date','to_date','time'));
    }
}
