<?php

namespace Modules\Merchant\Http\Controllers;

use App\Models\Merchant;
use App\Models\Package;
use App\Models\Store;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Company\Repositories\StoreRepository;
use Modules\Merchant\Repositories\MerchantPriceRepository;

class MerchantPriceController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public $repository ;
    public $store_repository;
    public function __construct()
    {
        $this->middleware('permission:prices_merchants', ['only' => ['index','update']]);

        $this->repository = new MerchantPriceRepository();
        $this->store_repository = new StoreRepository();
    }

    public function index(Merchant $merchant)
    {
        $data = $this->repository->index($merchant);
        $companies = $this->store_repository->all_companies();
        return view('merchant::merchant_prices.index',compact('merchant','data','companies'));
    }
    public function all_packages($id)
    {
        $stores = Store::where('parent_id',$id)->pluck('id')->toArray();
        $packages = Package::whereIn('store_id',$stores)->orderBy('id','desc')->get();
        $packages->map(function ($q){
           $q['name_ar'] = $q->name['ar'];
           return $q;
        });
        $data['packages']= $packages;
        return json_encode($data);
    }
    function all_imported_packages($id)
    {
        $packages = Package::where('store_id',$id)->orderBy('id','desc')->get();
        $packages->map(function ($q){
           $q['name_ar'] = $q->name['ar'];
           return $q;
        });
        $data['packages']= $packages;
        return json_encode($data);
    }
    public function all_categories($id)
    {
        $stores = Store::where('parent_id',$id)->get();
        $stores->map(function ($q){
           $q['name_ar'] = $q->name['ar'];
           return $q;
        });
        $data['categories']= $stores;
        return json_encode($data);
    }
    public function search(Request $request)
    {

        $merchant = Merchant::find($request->merchant_id);
        $updated = $this->repository->index($merchant);
        $result = $this->repository->search($request,$updated);
        $data = $this->repository->index($merchant);

        $view = view('merchant::merchant_prices.filter_data',compact('result','data','merchant'))->render();
        return response()->json(['html'=>$view]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('merchant::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('merchant::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('merchant::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, Merchant $merchant)
    {
        $updated = $this->repository->update($request, $merchant);
        return $updated ?
            redirect()->back()->with('success', trans('messages.updateOK')) :
            redirect()->back()->with('warning', trans('messages.updateNO'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy_selected_rows(Request $request)
    {
        $url = $this->repository->destroy_selected_rows($request);

        return $url
            ? json_encode(['code' => '1', 'url' => $url])
            : json_encode(['code' => '0', 'message' => 'نأسف لحدوث هذا الخطأ, برجاء المحاولة لاحقًا']);
    }
    public function profile_destroy_selected_rows(Request $request)
    {
        $url = $this->repository->profile_destroy_selected_rows($request);

        return $url
            ? json_encode(['code' => '1', 'url' => $url])
            : json_encode(['code' => '0', 'message' => 'نأسف لحدوث هذا الخطأ, برجاء المحاولة لاحقًا']);
    }
}
