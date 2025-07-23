<?php

namespace Modules\Transfers\Http\Controllers;

use App\Models\Distributor;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Transfers\Entities\Transfer;
use Modules\Transfers\Http\Requests\TransferRequest;
use Modules\Transfers\Repositories\TransferDistributorRepository;
use Modules\Transfers\Repositories\TransferRepository;

class TransfersDistributorController extends Controller
{

    public $repository;
    public $transferRepository;
    public function __construct()
    {
        $this->middleware('permission:create_distributors_transfers', ['only' => ['store_transfer', 'add_transfer']]);
        $this->middleware('permission:show_distributors_transfers', ['only' => ['view_transfer']]);

        $this->repository = new TransferDistributorRepository();
        $this->transferRepository = new TransferRepository();
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function view_transfer( Distributor $distributor)
    {
        $type = 'distributors';
        $name = getName($type);
        $data = $this->transferRepository->index($distributor);
        return view('transfers::transfers_distributors.view_transfers',compact('distributor','data','type','name'));
    }
    public function generate_pdf(Transfer $transfer)
    {

        $pdf = $this->transferRepository->generate_pdf($transfer,'distributors');
        return $pdf;

    }

    public function add_transfer(Request $request,Distributor $distributor)
    {
        $type = "distributors";
        return view('transfers::transfers_distributors.add_transfer',compact('distributor','type'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store_transfer(TransferRequest $request,Distributor $distributor)
    {
        $data = $this->repository->store_transfer($request,$distributor);
        return $data ?
            redirect()->route('admin.transfers.index','type=distributors')->with('success', trans('messages.addOK')) :
            redirect()->route('admin.transfers.index','type=distributors')->with('danger', "رصيدك لا يكفي للتحويل");
    }
    public function search(Request $request,Distributor $distributor)
    {
        $type =$request->type;
        $from_date =$request->from_date;
        $to_date =$request->to_date;
        $time =$request->time;
        $data = $this->transferRepository->search($request, $distributor);
        $name = getName($type);
        return view('transfers::transfers_distributors.view_transfers',compact('data','distributor','type','name'
            ,'from_date','to_date','time'));
    }



}
