<?php

namespace Modules\Collections\Http\Controllers;

use App\Models\Distributor;
use App\Models\Merchant;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Collections\Http\Requests\CollectionRequest;
use Modules\Collections\Repositories\CollectionDistributorRepository;
use Modules\Collections\Repositories\CollectionRepository;
use Modules\Transfers\Entities\Transfer;

class CollectionsDistributorController extends Controller
{
    public $repository;
    public $repositoryCollection;
    public function __construct()
    {
        $this->middleware('permission:create_distributors_collections', ['only' => ['add_collection', 'store_collection']]);
        $this->middleware('permission:show_distributors_collections', ['only' => ['view_collection']]);

        $this->repository = new CollectionDistributorRepository();
        $this->repositoryCollection = new CollectionRepository();
    }
    public function view_collection( Distributor $distributor)
    {
        $type = 'distributors';
        $name = getName($type);
        $data = $this->repositoryCollection->index($distributor);
        return view('collections::collections_distributors.view_collections',compact('distributor','data','type','name'));
    }
    public function generate_pdf(Transfer $collection)
    {

        $pdf = $this->repositoryCollection->generate_pdf($collection,'distributors');
        return $pdf;

    }
    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */

    public function add_collection(Request $request,Distributor $distributor)
    {
        $type = $request->type;
        return view('collections::collections_distributors.add_collection',compact('distributor','type'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store_collection(CollectionRequest $request,Distributor $distributor)
    {
        $data = $this->repository->store_collection($request,$distributor);
        return $data ?
            redirect()->route('admin.collections.index','type=distributors')->with('success', trans('messages.addOK')) :
            redirect()->route('admin.collections.index','type=distributors')->with('danger', "رصيدك لا يكفي للتحويل");
    }
    public function search(Request $request,Distributor $distributor)
    {
        $type =$request->type;
        $from_date =$request->from_date;
        $to_date =$request->to_date;
        $time =$request->time;
        $data = $this->repositoryCollection->search($request, $distributor);
        $name = getName($type);
        return view('collections::collections_distributors.view_collections',compact('data','distributor','type','name'
            ,'from_date','to_date','time'));
    }
}
