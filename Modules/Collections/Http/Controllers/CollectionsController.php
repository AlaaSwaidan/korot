<?php

namespace Modules\Collections\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Admin\Repositories\AdminRepository;
use Modules\Collections\Repositories\CollectionRepository;
use Modules\Distributor\Repositories\DistributorRepository;
use Modules\Merchant\Repositories\MerchantRepository;


class CollectionsController extends Controller
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
            $this->middleware('permission:view_merchant_collections');
        }elseif ($type == "distributors"){
            $this->middleware('permission:view_distributors_collections');
        }elseif ($type == "admins"){
            $this->middleware('permission:view_admins_collections');
        }

        $this->repository = new CollectionRepository();
        $this->merchantRepository = new MerchantRepository();
        $this->distributorRepository = new DistributorRepository();
        $this->adminRepository = new AdminRepository();
    }
    public function index()
    {

        $type =\request()->type;
        $data =getRepo($type,[$this->merchantRepository,$this->distributorRepository,$this->adminRepository]) ;
        $name = getName($type);
        return view('collections::collections_merchants.index',compact('data','name','type'));
    }



}
