<?php

namespace Modules\Collections\Http\Controllers;

use App\Models\Admin;
use App\Models\Distributor;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Collections\Http\Requests\CollectionRequest;
use Modules\Collections\Repositories\CollectionAdminRepository;
use Modules\Collections\Repositories\CollectionRepository;
use Modules\Transfers\Entities\Transfer;

class CollectionsAdminController extends Controller
{
    public $repository;
    public $repositoryCollection;
    public function __construct()
    {
        $this->middleware('permission:create_admins_collections', ['only' => ['add_collection', 'store_collection']]);
        $this->middleware('permission:show_admins_collections', ['only' => ['view_collection']]);

        $this->repository = new CollectionAdminRepository();
        $this->repositoryCollection = new CollectionRepository();
    }
    public function view_collection( Admin $admin)
    {
        $type = 'admins';
        $name = getName($type);
        $data = $this->repositoryCollection->index($admin);
        return view('collections::collections_admins.view_collections',compact('admin','data','type','name'));
    }
    public function generate_pdf(Transfer $collection)
    {

        $pdf = $this->repositoryCollection->generate_pdf($collection,'admins');
        return $pdf;

    }
    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */

    public function add_collection(Request $request,Admin $admin)
    {
        $type = $request->type;
        return view('collections::collections_admins.add_collection',compact('admin','type'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store_collection(CollectionRequest $request,Admin $admin)
    {
        $data = $this->repository->store_collection($request,$admin);
        return $data ?
            redirect()->route('admin.collections.index','type=admins')->with('success', trans('messages.addOK')) :
            redirect()->route('admin.collections.index','type=admins')->with('danger', "رصيدك لا يكفي للتحويل");
    }
    public function search(Request $request,Admin $admin)
    {
        $type =$request->type;
        $from_date =$request->from_date;
        $to_date =$request->to_date;
        $time =$request->time;
        $data = $this->repositoryCollection->search($request, $admin);
        $name = getName($type);
        return view('collections::collections_admins.view_collections',compact('data','admin','type','name'
            ,'from_date','to_date','time'));
    }
}
