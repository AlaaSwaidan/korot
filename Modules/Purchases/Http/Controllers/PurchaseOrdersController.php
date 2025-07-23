<?php

namespace Modules\Purchases\Http\Controllers;

use App\Http\Controllers\Api\ApiController;
use App\Models\Bank;
use App\Models\Currency;
use App\Models\Package;
use App\Models\PurchaseOrder;
use App\Models\PurchaseProduct;
use App\Models\Supplier;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Purchases\Repositories\PurchaseOrdersRepository;

class PurchaseOrdersController extends Controller
{
    public $repository;

    public function __construct()
    {
        $type = \request()->type;
        if ($type == "drafts"){
            $this->middleware('permission:view_purchase_orders');
        }else{
            $this->middleware('permission:view_invoices');
        }

        $this->middleware('permission:create_purchase_orders', ['only' => ['store','create']]);
        $this->middleware('permission:update_purchase_orders', ['only' => ['edit','update']]);
        $this->middleware('permission:delete_purchase_orders', ['only' => ['destroy_selected_rows','destroy']]);
        $this->middleware('permission:show_purchase_orders', ['only' => ['show']]);
        $this->middleware('permission:accept_purchase_orders', ['only' => ['confirm_page','confirm']]);

        $this->repository = new PurchaseOrdersRepository();
    }

    public function index()
    {
        $data = $this->repository->index(\request()->type);
        return view('purchases::purchase_orders.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $suppliers = Supplier::orderBy('id', 'desc')->get();
        $currencies = Currency::get();
        $packages = Package::get();
        return view('purchases::purchase_orders.create', compact('suppliers','currencies','packages'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $data = $this->repository->store($request);
        return $data['success'] == 1 ?  response()->json(['success'=>1,'url'=>route('admin.purchase-orders.index')])
            : response()->json(['success'=>0,'error'=>$data['data']]);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(PurchaseOrder $purchaseOrder)
    {
        $products = $purchaseOrder->products()->get();
        $qrcode = $purchaseOrder->generateQRCode();
        return view('purchases::purchase_orders.show', compact('purchaseOrder','qrcode','products'));
    }


    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(PurchaseOrder $purchaseOrder)
    {
        $suppliers = Supplier::orderBy('id', 'desc')->get();
        $currencies = Currency::get();
        $packages = Package::get();
        $banks = Bank::where('type','bank')->get();
        $purchaseProducts = PurchaseProduct::where('purchase_order_id',$purchaseOrder->id)->get();
        return view('purchases::purchase_orders.edit', compact('purchaseOrder','banks','purchaseProducts', 'suppliers', 'currencies','packages'));
    }

    public function confirm_page(PurchaseOrder $purchaseOrder)
    {
        $suppliers = Supplier::orderBy('id', 'desc')->get();
        $currencies = Currency::get();
        $packages = Package::get();
        $banks = Bank::where('type','bank')->get();
        $purchaseProducts = PurchaseProduct::where('purchase_order_id',$purchaseOrder->id)->get();
        return view('purchases::purchase_orders.confirm_page', compact('purchaseOrder','banks','purchaseProducts', 'suppliers', 'currencies','packages'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, PurchaseOrder $purchaseOrder)
    {
        $data = $this->repository->update($request, $purchaseOrder);

        return $data['success'] == 1 ?  response()->json(['success'=>1,'url'=>route('admin.purchase-orders.index')])
            : response()->json(['success'=>0,'error'=>$data['data']]);
    }
    public function confirm(Request $request, PurchaseOrder $purchaseOrder)
    {
        $data = $this->repository->confirm($request, $purchaseOrder);

        return $data['success'] == 1 ?  response()->json(['success'=>1,'url'=>route('admin.purchase-orders.index')])
            : response()->json(['success'=>0,'error'=>$data['data']]);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Request $request)
    {
        $deleted = $this->repository->destroy($request);
        $url = route('admin.purchase-orders.index');

        return $deleted
            ? json_encode(['code' => '1', 'url' => $url])
            : json_encode(['code' => '0', 'message' => 'نأسف لحدوث هذا الخطأ, برجاء المحاولة لاحقًا']);
    }

    public function destroy_selected_rows(Request $request)
    {
        $deleted = $this->repository->destroy_selected_rows($request);
        $url = route('admin.purchase-orders.index');

        return $deleted
            ? json_encode(['code' => '1', 'url' => $url])
            : json_encode(['code' => '0', 'message' => 'نأسف لحدوث هذا الخطأ, برجاء المحاولة لاحقًا']);
    }
}
