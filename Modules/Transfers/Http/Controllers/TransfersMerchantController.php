<?php

namespace Modules\Transfers\Http\Controllers;

use App\Models\Merchant;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Admin\Repositories\AdminRepository;
use Modules\Distributor\Repositories\DistributorRepository;
use Modules\Merchant\Repositories\MerchantRepository;
use Modules\Transfers\Entities\Transfer;
use Modules\Transfers\Http\Requests\TransferRequest;
use Modules\Transfers\Repositories\TransferRepository;

class TransfersMerchantController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public $repository;
    public $merchantRepository;
    public function __construct()
    {
        $type =\request()->type;
        if ($type == "merchants"){
            $this->middleware('permission:view_merchant_transfers');
        }elseif ($type == "distributors"){
            $this->middleware('permission:view_distributors_transfers');
        }elseif ($type == "admins"){
            $this->middleware('permission:view_admins_transfers');
        }
        $this->middleware('permission:create_merchant_transfers', ['only' => ['store_transfer', 'add_transfer']]);
        $this->middleware('permission:show_merchant_transfers', ['only' => ['view_transfer']]);

        $this->repository = new TransferRepository();
        $this->merchantRepository = new MerchantRepository();
        $this->distributorRepository = new DistributorRepository();
        $this->adminRepository = new AdminRepository();
    }
    public function index()
    {

        $type =\request()->type;
        $data =getRepo($type,[$this->merchantRepository,$this->distributorRepository,$this->adminRepository]) ;
        $name = getName($type);
        return view('transfers::transfers_merchants.index',compact('data','name','type'));
    }
    public function view_transfer( Merchant $merchant)
    {
        $type = 'merchants';
        $name = getName($type);
        $data = $this->repository->index($merchant);
        return view('transfers::transfers_merchants.view_transfers',compact('merchant','data','type','name'));
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

    public function add_transfer(Request $request,Merchant $merchant)
    {
        $type = "merchants";
        return view('transfers::transfers_merchants.add_transfer',compact('merchant','type'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store_transfer(TransferRequest $request,Merchant $merchant)
    {
        $data = $this->repository->store_transfer($request,$merchant);
        return $data ?
            redirect()->route('admin.transfers.index','type=merchants')->with('success', trans('messages.addOK')) :
            redirect()->route('admin.transfers.index','type=merchants')->with('danger', "رصيدك لا يكفي للتحويل");
    }
    public function search(Request $request,Merchant $merchant)
    {
        $type =$request->type;
        $from_date =$request->from_date;
        $to_date =$request->to_date;
        $time =$request->time;
        $data = $this->repository->search($request, $merchant);
        $name = getName($type);
        return view('transfers::transfers_merchants.view_transfers',compact('data','merchant','type','name'
            ,'from_date','to_date','time'));
    }

}
