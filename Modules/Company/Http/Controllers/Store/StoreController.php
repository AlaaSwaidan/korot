<?php

namespace Modules\Company\Http\Controllers\Store;

use App\Models\Merchant;
use App\Models\Store;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Company\Http\Requests\StoreRequest;
use Modules\Company\Repositories\StoreRepository;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public $repository;
    public function __construct()
    {
        $this->middleware('permission:view_stores');
        $this->middleware('permission:create_stores', ['only' => ['create', 'store']]);
        $this->middleware('permission:update_stores', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_stores', ['only' => ['destroy','destroy_selected_rows']]);

        $this->repository = new StoreRepository();
    }

    public function index()
    {
        $data = $this->repository->index();
        return view('company::stores.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $merchants = Merchant::Order()->where('approve',1)->where('id','!=',632)->get();
        return view('company::stores.create',compact('merchants'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(StoreRequest $request)
    {
        $data = $this->repository->store($request);
        return $data ?
            redirect()->route('admin.stores.index')->with('success', trans('messages.addOK')) :
            redirect()->route('admin.stores.index')->with('warning', trans('messages.addNO'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(Store $store)
    {
        return view('company::stores.show',compact('store'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Store $store)
    {
        $merchants = Merchant::Order()->where('approve',1)->where('id','!=',632)->get();
        $merchantIds = DB::table('merchant_stores')
            ->where('store_id', $store->id)
            ->pluck('merchant_id')->toArray();
        return view('company::stores.edit',compact('store','merchants','merchantIds'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(StoreRequest $request, Store $store)
    {
        //
        $updated = $this->repository->update($request, $store);
        return $updated ?
            redirect()->route('admin.stores.index')->with('success', trans('messages.updateOK')) :
            redirect()->route('admin.stores.index')->with('warning', trans('messages.updateNO'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Request $request)
    {
        $deleted = $this->repository->destroy($request);
        $url = route('admin.stores.index');

        return $deleted
            ? json_encode(['code' => '1', 'url' => $url])
            : json_encode(['code' => '0', 'message' => 'نأسف لحدوث هذا الخطأ, برجاء المحاولة لاحقًا']);
    }
    public function destroy_selected_rows(Request $request)
    {
        $deleted = $this->repository->destroy_selected_rows($request);
        $url = route('admin.stores.index');

        return $deleted
            ? json_encode(['code' => '1', 'url' => $url])
            : json_encode(['code' => '0', 'message' => 'نأسف لحدوث هذا الخطأ, برجاء المحاولة لاحقًا']);
    }
}
