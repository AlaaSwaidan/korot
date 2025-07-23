<?php

namespace Modules\Indebtedness\Http\Controllers;

use App\Models\Merchant;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Indebtedness\Repositories\IndebtednessMerchantRepository;
use Modules\Indebtedness\Repositories\IndebtednessRepository;
use Modules\Transfers\Entities\Transfer;
use Modules\Indebtedness\Http\Requests\IndebtednessRequest;

class MerchantController extends Controller
{
    public $repository;
    public $repositoryMerchant;
    public function __construct()
    {
        $this->middleware('permission:createIndebtedness_merchant_repayment', ['only' => ['add_indebtedness', 'store_indebtedness']]);
        $this->middleware('permission:createRepayment_merchant_repayment', ['only' => ['add_repayment', 'store_repayment']]);
        $this->middleware('permission:show_merchant_repayment', ['only' => ['view_indebtedness']]);

        $this->repository = new IndebtednessRepository();
        $this->repositoryMerchant = new IndebtednessMerchantRepository();
    }
    public function view_indebtedness( Merchant $merchant)
    {
        $type = 'merchants';
        $name = getName($type);
        $data = $this->repository->index($merchant);
        return view('indebtedness::merchants.view_indebtedness',compact('merchant','data','type','name'));
    }
    public function generate_pdf(Transfer $transfer)
    {

        $pdf = $this->repository->generate_pdf($transfer,'merchant');
        return $pdf;

    }
    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */

    public function add_indebtedness(Request $request,Merchant $merchant)
    {
        $type = $request->type;
        return view('indebtedness::merchants.add_indebtedness',compact('merchant','type'));
    }
    public function add_repayment(Request $request,Merchant $merchant)
    {
        $type = $request->type;
        return view('indebtedness::merchants.add_repayment',compact('merchant','type'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store_indebtedness(IndebtednessRequest $request,Merchant $merchant)
    {
        $data = $this->repositoryMerchant->store_indebtedness($request,$merchant);
        return $data ?
            redirect()->route('admin.indebtedness.index','type=merchants')->with('success', trans('messages.addOK')) :
            redirect()->route('admin.indebtedness.index','type=merchants')->with('danger', "رصيدك لا يكفي للتحويل");
    }
    public function store_repayment(IndebtednessRequest $request,Merchant $merchant)
    {
        $data = $this->repositoryMerchant->store_repayment($request,$merchant);
        return $data ?
            redirect()->route('admin.indebtedness.index','type=merchants')->with('success', trans('messages.addOK')) :
            redirect()->route('admin.indebtedness.index','type=merchants')->with('danger', "رصيدك لا يكفي للتحويل");
    }
    public function search(Request $request,Merchant $merchant)
    {
        $type =$request->type;
        $from_date =$request->from_date;
        $to_date =$request->to_date;
        $time =$request->time;
        $data = $this->repository->search($request, $merchant);
        $name = getName($type);
        return view('indebtedness::merchants.view_indebtedness',compact('data','merchant','type','name'
            ,'from_date','to_date','time'));
    }
}
