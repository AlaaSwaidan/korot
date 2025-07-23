<?php

namespace Modules\Transfers\Http\Controllers;

use App\Models\Admin;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Transfers\Entities\Transfer;
use Modules\Transfers\Http\Requests\TransferRequest;
use Modules\Transfers\Repositories\TransferAdminRepository;
use Modules\Transfers\Repositories\TransferRepository;

class TransfersAdminController extends Controller
{
    public $repository;
    public $transferRepository;
    public function __construct()
    {
        $this->middleware('permission:create_admins_transfers', ['only' => ['store_transfer', 'add_transfer']]);
        $this->middleware('permission:show_admins_transfers', ['only' => ['view_transfer']]);

        $this->repository = new TransferAdminRepository();
        $this->transferRepository = new TransferRepository();
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function view_transfer( Admin $admin)
    {
        $type = 'admins';
        $name = getName($type);
        $data = $this->transferRepository->index($admin);
        return view('transfers::transfers_admins.view_transfers',compact('admin','data','type','name'));
    }
    public function generate_pdf(Transfer $transfer)
    {

        $pdf = $this->transferRepository->generate_pdf($transfer,'admins');
        return $pdf;

    }

    public function add_transfer(Request $request,Admin $admin)
    {
        $type = "admins";
        return view('transfers::transfers_admins.add_transfer',compact('admin','type'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store_transfer(TransferRequest $request,Admin $admin)
    {
        $data = $this->repository->store_transfer($request,$admin);
        return $data ?
            redirect()->route('admin.transfers.index','type=admins')->with('success', trans('messages.addOK')) :
            redirect()->route('admin.transfers.index','type=admins')->with('danger', "رصيدك لا يكفي للتحويل");
    }
    public function search(Request $request,Admin $admin)
    {
        $type =$request->type;
        $from_date =$request->from_date;
        $to_date =$request->to_date;
        $time =$request->time;
        $data = $this->transferRepository->search($request, $admin);
        $name = getName($type);
        return view('transfers::transfers_admins.view_transfers',compact('data','admin','type','name'
            ,'from_date','to_date','time'));
    }
}
