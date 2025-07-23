<?php

namespace Modules\Indebtedness\Http\Controllers;

use App\Models\Distributor;
use App\Models\Merchant;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Indebtedness\Repositories\IndebtednessDistributorRepository;
use Modules\Indebtedness\Repositories\IndebtednessMerchantRepository;
use Modules\Indebtedness\Repositories\IndebtednessRepository;
use Modules\Transfers\Entities\Transfer;
use Modules\Indebtedness\Http\Requests\IndebtednessRequest;

class DistributorController extends Controller
{
    public $repository;
    public $repositorydistributor;
    public function __construct()
    {
        $this->middleware('permission:createIndebtedness_distributors_repayment', ['only' => ['add_indebtedness', 'store_indebtedness']]);
        $this->middleware('permission:createRepayment_distributors_repayment', ['only' => ['add_repayment', 'store_repayment']]);
        $this->middleware('permission:show_distributors_repayment', ['only' => ['view_indebtedness']]);

        $this->repository = new IndebtednessRepository();
        $this->repositorydistributor = new IndebtednessDistributorRepository();
    }
    public function view_indebtedness( Distributor $distributor)
    {
        $type = 'distributors';
        $name = getName($type);
        $data = $this->repository->index($distributor);
        return view('indebtedness::distributors.view_indebtedness',compact('distributor','data','type','name'));
    }
    public function generate_pdf(Transfer $transfer)
    {

        $pdf = $this->repository->generate_pdf($transfer,'distributors');
        return $pdf;

    }
    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */

    public function add_indebtedness(Request $request, Distributor $distributor)
    {
        $type = $request->type;
        return view('indebtedness::distributors.add_indebtedness',compact('distributor','type'));
    }
    public function add_repayment(Request $request, Distributor $distributor)
    {
        $type = $request->type;
        return view('indebtedness::distributors.add_repayment',compact('distributor','type'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store_indebtedness(IndebtednessRequest $request, Distributor $distributor)
    {
        $data = $this->repositorydistributor->store_indebtedness($request,$distributor);
        return $data ?
            redirect()->route('admin.indebtedness.index','type=distributors')->with('success', trans('messages.addOK')) :
            redirect()->route('admin.indebtedness.index','type=distributors')->with('danger', "رصيدك لا يكفي للتحويل");
    }
    public function store_repayment(IndebtednessRequest $request, Distributor $distributor)
    {
        $data = $this->repositorydistributor->store_repayment($request,$distributor);
        return $data ?
            redirect()->route('admin.indebtedness.index','type=distributors')->with('success', trans('messages.addOK')) :
            redirect()->route('admin.indebtedness.index','type=distributors')->with('danger', "رصيدك لا يكفي للتحويل");
    }
    public function search(Request $request,Merchant $merchant)
    {
        $type =$request->type;
        $from_date =$request->from_date;
        $to_date =$request->to_date;
        $time =$request->time;
        $data = $this->repository->search($request, $merchant);
        $name = getName($type);
        return view('indebtedness::distributors.view_indebtedness',compact('data','merchant','type','name'
            ,'from_date','to_date','time'));
    }
}
