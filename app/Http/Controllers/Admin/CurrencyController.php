<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CurrencyRequest;
use App\Models\Admin;
use App\Models\Currency;
use App\Models\PurchaseOrder;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function __construct()
    {

        $this->middleware('permission:view_currencies');
        $this->middleware('permission:create_currencies', ['only' => ['store','create']]);
        $this->middleware('permission:update_currencies', ['only' => ['edit','update']]);
        $this->middleware('permission:delete_currencies', ['only' => ['destroy_selected_rows','destroy']]);


    }
    public function index()
    {
        $data = Currency::orderBy('id', 'DESC')->paginate(10);

        return view('admin.currencies.index', compact('data'));
    }

    public function create()
    {
        return view('admin.currencies.create');
    }
//
    public function store(CurrencyRequest $request) {

        $data = Currency::create($request->all());

        return $data ?
            redirect()->route('admin.currencies.index')->with('success', trans('messages.addOK')) :
            redirect()->route('admin.currencies.index')->with('warning', trans('messages.addNO'));
    }

    public function edit(Currency $currency) {

        return view('admin.currencies.edit', compact('currency'));
    }

    public function update(CurrencyRequest $request, Currency $currency) {

        $updated = $currency->update($request->all());

        return $updated ?
            redirect()->route('admin.currencies.index')->with('success', trans('messages.updateOK')) :
            redirect()->route('admin.currencies.index')->with('warning', trans('messages.updateNO'));
    }




    public function destroy(Request $request) {

        $data = Currency::find($request->id);

        //check-if-this-currency-signed to products
        if( PurchaseOrder::where('currency_id',$data->id)->count() > 0)
            return json_encode(['code' => '2', 'message' => trans('messages.cant_delete')]);

        $deleted = $data->delete();
        $url = route('admin.currencies.index');

        return $deleted
            ? json_encode(['code' => '1', 'url' => $url])
            : json_encode(['code' => '0', 'message' => 'نأسف لحدوث هذا الخطأ, برجاء المحاولة لاحقًا']);
    }
    public function destroy_selected_rows(Request $request)
    {

        try {
            $deleted = Currency::whereIn('id',$request->ids)->where('id','!=',null)->delete();
            $url = route('admin.currencies.index');
            return $deleted
                ? json_encode(['code' => '1', 'url' => $url])
                : json_encode(['code' => '0', 'message' => 'نأسف لحدوث هذا الخطأ, برجاء المحاولة لاحقًا']);

        } catch (\Exception $exception) {
            return redirect()->route('admin.currencies.index')->with('warning', 'Error , contact system');

        }


   }
}
