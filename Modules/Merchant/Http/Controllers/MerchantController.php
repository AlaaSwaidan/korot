<?php

namespace Modules\Merchant\Http\Controllers;

use App\Exports\TransferExport;
use App\Exports\ProcessExport;
use App\Models\City;
use App\Models\Merchant;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Collections\Repositories\CollectionRepository;
use Modules\Company\Repositories\StoreRepository;
use Modules\Merchant\Http\Requests\MerchantGeideaRequest;
use Modules\Merchant\Http\Requests\MerchantRequest;
use Modules\Merchant\Repositories\MerchantPriceRepository;
use Modules\Merchant\Repositories\MerchantRepository;
use Modules\Transfers\Repositories\TransferRepository;

class MerchantController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public $repository ;
    public $repositoryPrice ;
    public $repositoryTransfers ;
    public $repositoryCollections ;
    public function __construct()
    {
        $this->middleware('permission:view_merchants');
        $this->middleware('permission:create_merchants', ['only' => ['create', 'store']]);
        $this->middleware('permission:update_merchants', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_merchants', ['only' => ['destroy','destroy_selected_rows']]);
        $this->middleware('permission:show_merchants', ['only' => ['show']]);
        $this->middleware('permission:changePass_merchants', ['only' => ['showChangePasswordForm','updateAdminPassword']]);
        $this->middleware('permission:waitingShow_merchants', ['only' => ['show']]);

        $this->repository = new MerchantRepository();
        $this->repositoryPrice = new MerchantPriceRepository();
        $this->repositoryTransfers = new TransferRepository();
        $this->repositoryCollections = new CollectionRepository();
        $this->store_repository = new StoreRepository();
    }

    public function index()
    {
        $data = $this->repository->index();
        return view('merchant::merchants.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $cities =  City::where('country_id',178)->get();
        return view('merchant::merchants.create',compact('cities'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(MerchantRequest $request)
    {
        $data = $this->repository->store($request);
        return $data ?
            redirect()->route('admin.merchants.index')->with('success', trans('messages.addOK')) :
            redirect()->route('admin.merchants.index')->with('warning', trans('messages.addNO'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(Merchant $merchant)
    {
        return view('merchant::merchants.show',compact('merchant'));
    }
    public function prices(Merchant $merchant)
    {
         $data = $this->repositoryPrice->index($merchant);
        $companies = $this->store_repository->all_companies();
        return view('merchant::merchants.prices',compact('merchant','companies','data'));
    }
    public function geidea_info(Merchant $merchant)
    {
        return view('merchant::merchants.geidea_info',compact('merchant'));
    }
    public function edit_geidea_info(Merchant $merchant)
    {
        return view('merchant::merchants.edit_geidea',compact('merchant'));
    }
    public function update_geidea(MerchantGeideaRequest $request,Merchant $merchant)
    {
        $updated = $this->repository->update_geidea($request, $merchant);
        return $updated ?
            redirect()->route('admin.merchants.geidea-info',$merchant->id)->with('success', trans('messages.updateOK')) :
            redirect()->route('admin.merchants.geidea-info',$merchant->id)->with('warning', trans('messages.updateNO'));
    }
    public function transfers(Merchant $merchant)
    {
         $data = $this->repositoryTransfers->index($merchant);
        return view('merchant::merchants.transfers',compact('merchant','data'));
    }

    public function collections(Merchant $merchant)
    {
         $data = $this->repositoryCollections->index($merchant);
        return view('merchant::merchants.collections',compact('merchant','data'));
    }
    public function sales(Merchant $merchant)
    {
         $data = $this->repository->orders($merchant);
        return view('merchant::merchants.sales',compact('merchant','data'));
    }
    public function sales_reports(Merchant $merchant)
    {

        return view('merchant::merchants.sales_reports',compact('merchant'));
    }
    public function sales_invoice(Merchant $merchant)
    {

        return view('merchant::merchants.sales_invoice',compact('merchant'));
    }
    public function sales_reports_print(Request $request,Merchant $merchant)
    {
        $pdf = $this->repository->generate_pdf($merchant,$request);
        return $pdf;

    }
    public function sales_invoice_print(Request $request,Merchant $merchant)
    {
        $pdf = $this->repository->sales_invoice_print($merchant,$request);
        return $pdf;

    }
    public function processes(Merchant $merchant)
    {
        $data =$merchant->userable()
            ->where('paid_order','paid')
            ->Order()->paginate(20)->appends(request()->except('page'));

        return view('merchant::merchants.processes',compact('merchant','data'));
    }
    public function accounts(Request $request,Merchant $merchant)
    {
        $data =$merchant->userable()->Order();
        $new_data = clone $data;
        $startDate = $request->from_date;
        $endDate = $request->to_date;
        $time =$request->time ? $request->time : 'today';
        if ($time == "today") {
            $last_data = $data->whereDate('created_at', Carbon::now())->get();
            $first_data = $new_data->whereDate('created_at', '<', Carbon::now())->first();
            $today = ' التاريخ '.Carbon::now()->format('Y-m-d');
        }
        if ($time == "exact_time"){
            $startDate = Carbon::parse($request->from_date);
            $endDate = Carbon::parse($request->to_date);

            $last_data = $data->whereBetween(\DB::raw('DATE(created_at)'), [$startDate, $endDate])->get();
            $data =$data->whereBetween(\DB::raw('DATE(created_at)'), [$startDate, $endDate])
                ->get()
                ->groupBy([
                    function ($val) { return $val->created_at->format('m'); },
                    function ($val) { return $val->created_at->format('d'); }
                ]);

//            foreach($data as $key => $value){
//                dd($value);
//            }
//            dd($data);


            $first_data = $new_data->whereDate('created_at', '<', $startDate)->first();
            $today =' التاريخ '.$startDate->format('Y-m-d').' الى '.$endDate->format('Y-m-d');
        }

//        $data =$data->paginate(20)->appends(request()->except('page'));
        return view('merchant::merchants.accounts',compact('merchant','last_data','data','first_data','today','time','startDate','endDate'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Merchant $merchant)
    {
        $cities =  City::where('country_id',178)->get();
        return view('merchant::merchants.edit',compact('merchant','cities'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(MerchantRequest $request, Merchant $merchant)
    {
        $updated = $this->repository->update($request, $merchant);
        return $updated ?
            redirect()->route('admin.merchants.index')->with('success', trans('messages.updateOK')) :
            redirect()->route('admin.merchants.index')->with('warning', trans('messages.updateNO'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Request $request)
    {
        $deleted = $this->repository->destroy($request);
        $url = route('admin.merchants.index');

        return $deleted
            ? json_encode(['code' => '1', 'url' => $url])
            : json_encode(['code' => '0', 'message' => 'نأسف لحدوث هذا الخطأ, برجاء المحاولة لاحقًا']);
    }
    public function destroy_token(Request $request)
    {
        $deleted = $this->repository->destroy_token($request);
        $url = route('admin.merchants.index');
        return json_encode(['code' => '1', 'url' => $url]);
    }
    public function destroy_selected_rows(Request $request)
    {
        $deleted = $this->repository->destroy_selected_rows($request);
        $url = route('admin.merchants.index');

        return $deleted
            ? json_encode(['code' => '1', 'url' => $url])
            : json_encode(['code' => '0', 'message' => 'نأسف لحدوث هذا الخطأ, برجاء المحاولة لاحقًا']);
    }
    public function showChangePasswordForm(Merchant $merchant){
        return view('merchant::merchants.change_password', compact('merchant'));

    }
    public function updateAdminPassword(Request $request, Merchant $merchant) {

        $request->validate([
            'new_password'      => 'required|min:3|max:191',
            'password_confirm'  => 'same:new_password',
        ]);

        $updated =   $this->repository->update_password($request,$merchant);
        return $updated ?
            redirect()->route('admin.merchants.index')->with('success', 'تم تغيير كلمة مرور تاجر بنجاح') :
            redirect()->route('admin.merchants.index')->with('warning', 'حدث خطأ ما, برجاء المحاولة مرة اخرى');
    }
}
