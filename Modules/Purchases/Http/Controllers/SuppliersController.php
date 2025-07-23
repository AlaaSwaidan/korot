<?php

namespace Modules\Purchases\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use App\Models\Supplier;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Purchases\Http\Requests\SupplierRequest;
use Modules\Purchases\Repositories\SupplierRepository;

class SuppliersController extends Controller
{


    public $repository ;

    public function __construct()
    {
        $this->middleware('permission:view_suppliers');
        $this->middleware('permission:create_suppliers', ['only' => ['store','create']]);
        $this->middleware('permission:update_suppliers', ['only' => ['edit','update']]);
        $this->middleware('permission:destroy_suppliers', ['only' => ['destroy_selected_rows','destroy']]);
        $this->middleware('permission:show_suppliers', ['only' => ['show']]);

        $this->repository = new SupplierRepository();
    }

    public function index()
    {
        $data = $this->repository->index();
        return view('purchases::suppliers.index',compact('data'));
    }



    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $countries = Country::where('status',1)->get();
        $cities = City::where('country_id',178)->get();
        $get_suppliers = Supplier::orderBy('id','desc')->first();
        $code =$get_suppliers ? $get_suppliers->supplier_id + 1 :1;

        return view('purchases::suppliers.create',compact('countries','cities','code'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(SupplierRequest $request)
    {
        $data = $this->repository->store($request);
        return $data ?
            redirect()->route('admin.suppliers.index')->with('success', trans('messages.addOK')) :
            redirect()->route('admin.suppliers.index')->with('warning', trans('messages.addNO'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(Supplier $supplier)
    {
        return view('purchases::suppliers.show',compact('supplier'));
    }

    public function invoices(Supplier $supplier)
    {
        $invoices = $supplier->invoices()->orderBy('id','desc')->paginate(10);
        return view('purchases::suppliers.invoices',compact('invoices','supplier'));
    }


    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Supplier $supplier)
    {
        $countries = Country::where('status',1)->get();
        $cities = City::where('country_id',178)->get();
        return view('purchases::suppliers.edit',compact('supplier','countries','cities'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(SupplierRequest $request, Supplier $supplier)
    {
        $updated = $this->repository->update($request, $supplier);
        return $updated ?
            redirect()->route('admin.suppliers.index')->with('success', trans('messages.updateOK')) :
            redirect()->route('admin.suppliers.index')->with('warning', trans('messages.updateNO'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Request $request)
    {
        $deleted = $this->repository->destroy($request);
        $url = route('admin.suppliers.index');

        return $deleted
            ? json_encode(['code' => '1', 'url' => $url])
            : json_encode(['code' => '0', 'message' => 'نأسف لحدوث هذا الخطأ, برجاء المحاولة لاحقًا']);
    }
    public function destroy_selected_rows(Request $request)
    {
        $deleted = $this->repository->destroy_selected_rows($request);
        $url = route('admin.suppliers.index');

        return $deleted
            ? json_encode(['code' => '1', 'url' => $url])
            : json_encode(['code' => '0', 'message' => 'نأسف لحدوث هذا الخطأ, برجاء المحاولة لاحقًا']);
    }
}
