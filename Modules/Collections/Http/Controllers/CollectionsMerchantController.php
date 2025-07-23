<?php

namespace Modules\Collections\Http\Controllers;

use App\Models\Merchant;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Collections\Repositories\CollectionRepository;
use Modules\Transfers\Entities\Transfer;
use Modules\Collections\Http\Requests\CollectionRequest;

class CollectionsMerchantController extends Controller
{
    public $repository;
    public function __construct()
    {
        $this->middleware('permission:create_merchant_collections', ['only' => ['add_collection', 'store_collection']]);
        $this->middleware('permission:show_merchant_collections', ['only' => ['view_collection']]);

        $this->repository = new CollectionRepository();
    }
    public function view_collection( Merchant $merchant)
    {
        $type = 'merchants';
        $name = getName($type);
        $data = $this->repository->index($merchant);
        return view('collections::collections_merchants.view_collections',compact('merchant','data','type','name'));
    }
    public function generate_pdf(Transfer $collection)
    {

        $pdf = $this->repository->generate_pdf($collection,'merchant');
        return $pdf;

    }
    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */

    public function add_collection(Request $request,Merchant $merchant)
    {
        $type = $request->type;
        return view('collections::collections_merchants.add_collection',compact('merchant','type'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store_collection(CollectionRequest $request,Merchant $merchant)
    {
        $data = $this->repository->store_collection($request,$merchant);
        return $data ?
            redirect()->route('admin.collections.index','type=merchants')->with('success', trans('messages.addOK')) :
            redirect()->route('admin.collections.index','type=merchants')->with('danger', "رصيدك لا يكفي للتحويل");
    }
    public function search(Request $request,Merchant $merchant)
    {
        $type =$request->type;
        $from_date =$request->from_date;
        $to_date =$request->to_date;
        $time =$request->time;
        $data = $this->repository->search($request, $merchant);
        $name = getName($type);
        return view('collections::collections_merchants.view_collections',compact('data','merchant','type','name'
            ,'from_date','to_date','time'));
    }
}
