<?php

namespace Modules\Indebtedness\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Admin\Repositories\AdminRepository;
use Modules\Distributor\Repositories\DistributorRepository;
use Modules\Indebtedness\Repositories\IndebtednessRepository;
use Modules\Merchant\Repositories\MerchantRepository;

class IndebtednessController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public $merchantRepository;
    public $distributorRepository;
    public $adminRepository;
    public function __construct()
    {
        $type =\request()->type;
        if ($type == "merchants"){
            $this->middleware('permission:view_merchant_repayment');
        }elseif ($type == "distributors"){
            $this->middleware('permission:view_distributors_repayment');
        }elseif ($type == "admins"){
            $this->middleware('permission:view_admins_repayment');
        }
        $this->merchantRepository = new MerchantRepository();
        $this->distributorRepository = new DistributorRepository();
        $this->adminRepository = new AdminRepository();
    }
    public function index()
    {

        $type =\request()->type;
        $data =getRepo($type,[$this->merchantRepository,$this->distributorRepository,$this->adminRepository]) ;
        $name = getName($type);
        return view('indebtedness::merchants.index',compact('data','name','type'));
    }

}
