<?php

namespace Modules\Distributor\Http\Controllers;

use App\Models\Distributor;
use App\Models\Merchant;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Collections\Repositories\CollectionRepository;
use Modules\Distributor\Http\Requests\DistributorRequest;
use Modules\Distributor\Repositories\DistributorRepository;
use Modules\Merchant\Repositories\MerchantPriceRepository;
use Modules\Transfers\Entities\Transfer;
use Modules\Transfers\Repositories\TransferRepository;

class DistributorController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public $repository ;
    public function __construct()
    {
        $this->middleware('permission:view_distributors');
        $this->middleware('permission:create_distributors', ['only' => ['create', 'store']]);
        $this->middleware('permission:update_distributors', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_distributors', ['only' => ['destroy','destroy_selected_rows']]);
        $this->middleware('permission:show_distributors', ['only' => ['show']]);
        $this->middleware('permission:changePass_distributors', ['only' => ['showChangePasswordForm','updateAdminPassword']]);

        $this->repository = new DistributorRepository();
        $this->repositoryTransfers = new TransferRepository();
        $this->repositoryCollections = new CollectionRepository();
    }

    public function index()
    {
        $data = $this->repository->index();
        return view('distributor::distributors.index',compact('data'));
    }
    public function search_machine()
    {
        $machine = \request()->machine;
        $data = [];
        if ($machine){
            $data = Merchant::Order()->where('machine_number',$machine)->paginate(20)->appends(request()->except('page'));
        }
        return view('distributor::distributors.search_machine',compact('data','machine'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('distributor::distributors.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(DistributorRequest $request)
    {
        //
        $data = $this->repository->store($request);
        return $data ?
            redirect()->route('admin.distributors.index')->with('success', trans('messages.addOK')) :
            redirect()->route('admin.distributors.index')->with('warning', trans('messages.addNO'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(Distributor $distributor)
    {
        $ids = $distributor->merchants()->pluck('merchants.id')->toArray();
        $sales_merchant_wallet = Order::where('parent_id',null)->where('paid_order',"paid")->whereIn('merchant_id',$ids)->where('payment_method','wallet')->sum('card_price');
        $sales_merchant_geadia = Order::where('parent_id',null)->where('paid_order',"paid")->whereIn('merchant_id',$ids)->where('payment_method','online')->sum('card_price');

        return view('distributor::distributors.show',compact('distributor','sales_merchant_wallet','sales_merchant_geadia'));
    }
    public function add_merchants(Distributor $distributor)
    {
        $data = Merchant::Order()->where('approve',1)->where(function ($q) use($distributor){
            $q->where('distributor_id',null);
            $q->orWhere('distributor_id',$distributor->id);
        })->paginate(20)->appends(request()->except('page'));

        $ids = $distributor->merchants()->pluck('merchants.id')->toArray();
        $sales_merchant_wallet = Order::where('parent_id',null)->where('paid_order',"paid")->whereIn('merchant_id',$ids)->where('payment_method','wallet')->sum('card_price');
        $sales_merchant_geadia = Order::where('parent_id',null)->where('paid_order',"paid")->whereIn('merchant_id',$ids)->where('payment_method','online')->sum('card_price');
        return view('distributor::distributors.add_merchants',compact('distributor','data','sales_merchant_geadia','sales_merchant_wallet'));
    }
    public function store_merchants(Request $request,Distributor $distributor)
    {
//        dd($request->all());
        if ($request->checkboxstatus == "false"){
            $data = Merchant::where('id',$request->merchants)->update([
                'distributor_id'=>null
            ]);
            return response()->json(['message' => 'تم حذف التاجر بنجاح', 'success'=>0]);
        }else{
            $data = Merchant::where('id',$request->merchants)->update([
                'distributor_id'=>$distributor->id
            ]);
            return response()->json(['message' => 'تم اضافة التاجر بنجاح', 'success'=>1]);
        }
//        Merchant::where('distributor_id',$distributor->id)->update([
//            'distributor_id'=>null
//        ]);
//        $data = Merchant::whereIn('id',$request->merchants)->update([
//            'distributor_id'=>$distributor->id
//        ]);



    }
    public function transfers(Distributor $distributor)
    {
        $data = $this->repositoryTransfers->index($distributor);
        $ids = $distributor->merchants()->pluck('merchants.id')->toArray();
        $sales_merchant_wallet = Order::where('parent_id',null)->where('paid_order',"paid")->whereIn('merchant_id',$ids)->where('payment_method','wallet')->sum('card_price');
        $sales_merchant_geadia = Order::where('parent_id',null)->where('paid_order',"paid")->whereIn('merchant_id',$ids)->where('payment_method','online')->sum('card_price');
        return view('distributor::distributors.transfers',compact('distributor','data','sales_merchant_geadia','sales_merchant_wallet'));
    }
    public function transfers_to_merchants(Distributor $distributor)
    {
        $data =Transfer::orderBy('id','desc')->where('type','transfer')->where('providerable_type','App\Models\Distributor')
            ->where('providerable_id',$distributor->id)->where('confirm',1)->paginate(20);
        $ids = $distributor->merchants()->pluck('merchants.id')->toArray();
        $sales_merchant_wallet = Order::where('parent_id',null)->where('paid_order',"paid")->whereIn('merchant_id',$ids)->where('payment_method','wallet')->sum('card_price');
        $sales_merchant_geadia = Order::where('parent_id',null)->where('paid_order',"paid")->whereIn('merchant_id',$ids)->where('payment_method','online')->sum('card_price');
        return view('distributor::my_profile.transfers_to_merchants',compact('distributor','data','sales_merchant_geadia','sales_merchant_wallet'));
    }
    public function process_for_distributors_merchants(Distributor $distributor)
    {
        $data =Transfer::orderBy('id','desc')->where('providerable_type','App\Models\Distributor')
            ->where('providerable_id',$distributor->id)->where('confirm',1)->paginate(20);
        $total_transfers = Transfer::orderBy('id','desc')->where('providerable_type','App\Models\Distributor')
            ->where('providerable_id',$distributor->id)->where('confirm',1)->where('type','transfer')->sum('amount');
        $total_collection = Transfer::orderBy('id','desc')->where('providerable_type','App\Models\Distributor')
            ->where('providerable_id',$distributor->id)->where('confirm',1)->where('type','collection')->sum('amount');
        $ids = $distributor->merchants()->pluck('merchants.id')->toArray();
        $sales_merchant_wallet = Order::where('parent_id',null)->where('paid_order',"paid")->whereIn('merchant_id',$ids)->where('payment_method','wallet')->sum('card_price');
        $sales_merchant_geadia = Order::where('parent_id',null)->where('paid_order',"paid")->whereIn('merchant_id',$ids)->where('payment_method','online')->sum('card_price');
        return view('distributor::my_profile.process_for_distributors_merchants',compact('distributor','data','total_collection','total_transfers','sales_merchant_geadia','sales_merchant_wallet'));
    }
    public function sales_distributors_merchants(Distributor $distributor)
    {

        $ids = $distributor->merchants()->pluck('merchants.id')->toArray();
        $data =Order::where('parent_id',null)->where('paid_order',"paid")->orderBy('id','desc')->whereIn('merchant_id',$ids)->paginate(20);
        $sales_merchant_wallet = Order::where('parent_id',null)->where('paid_order',"paid")->whereIn('merchant_id',$ids)->where('payment_method','wallet')->sum('card_price');
        $sales_merchant_geadia = Order::where('parent_id',null)->where('paid_order',"paid")->whereIn('merchant_id',$ids)->where('payment_method','online')->sum('card_price');

        return view('distributor::my_profile.sales_distributors_merchants',compact('distributor','data','sales_merchant_geadia','sales_merchant_wallet'));
    }
    public function distributors_merchants(Distributor $distributor)
    {
        $ids = $distributor->merchants()->pluck('merchants.id')->toArray();
        $data = $distributor->merchants()->paginate(20);
        $sales_merchant_wallet = Order::where('parent_id',null)->where('paid_order',"paid")->whereIn('merchant_id',$ids)->where('payment_method','wallet')->sum('card_price');
        $sales_merchant_geadia = Order::where('parent_id',null)->where('paid_order',"paid")->whereIn('merchant_id',$ids)->where('payment_method','online')->sum('card_price');

        return view('distributor::my_profile.distributors_merchants',compact('distributor','data','sales_merchant_geadia','sales_merchant_wallet'));
    }

    public function collect_from_merchants(Distributor $distributor)
    {
        $data =Transfer::orderBy('id','desc')->where('type','collection')->where('providerable_type','App\Models\Distributor')
            ->where('providerable_id',$distributor->id)->where('confirm',1)->paginate(20);
        $ids = $distributor->merchants()->pluck('merchants.id')->toArray();
        $sales_merchant_wallet = Order::where('parent_id',null)->where('paid_order',"paid")->whereIn('merchant_id',$ids)->where('payment_method','wallet')->sum('card_price');
        $sales_merchant_geadia = Order::where('parent_id',null)->where('paid_order',"paid")->whereIn('merchant_id',$ids)->where('payment_method','online')->sum('card_price');
        return view('distributor::my_profile.collect_from_merchants',compact('distributor','data','sales_merchant_geadia','sales_merchant_wallet'));
    }

    public function collections(Distributor $distributor)
    {
        $data = $this->repositoryCollections->index($distributor);
        $ids = $distributor->merchants()->pluck('merchants.id')->toArray();
        $sales_merchant_wallet = Order::where('parent_id',null)->where('paid_order',"paid")->whereIn('merchant_id',$ids)->where('payment_method','wallet')->sum('card_price');
        $sales_merchant_geadia = Order::where('parent_id',null)->where('paid_order',"paid")->whereIn('merchant_id',$ids)->where('payment_method','online')->sum('card_price');
        return view('distributor::distributors.collections',compact('distributor','data','sales_merchant_geadia','sales_merchant_wallet'));
    }

    public function processes(Distributor $distributor)
    {
        $data =$distributor->userable()->Order()->paginate(20)->appends(request()->except('page'));
        $ids = $distributor->merchants()->pluck('merchants.id')->toArray();
        $sales_merchant_wallet = Order::where('parent_id',null)->where('paid_order',"paid")->whereIn('merchant_id',$ids)->where('payment_method','wallet')->sum('card_price');
        $sales_merchant_geadia = Order::where('parent_id',null)->where('paid_order',"paid")->whereIn('merchant_id',$ids)->where('payment_method','online')->sum('card_price');
        return view('distributor::distributors.processes',compact('distributor','data','sales_merchant_geadia','sales_merchant_wallet'));
    }
    public function accounts(Request $request,Distributor $distributor)
    {
        $data =$distributor->userable()->Order();
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
        $ids = $distributor->merchants()->pluck('merchants.id')->toArray();
        $sales_merchant_wallet = Order::where('parent_id',null)->where('paid_order',"paid")->whereIn('merchant_id',$ids)->where('payment_method','wallet')->sum('card_price');
        $sales_merchant_geadia = Order::where('parent_id',null)->where('paid_order',"paid")->whereIn('merchant_id',$ids)->where('payment_method','online')->sum('card_price');
        return view('distributor::distributors.accounts',compact('distributor','last_data','data','first_data','today','time','startDate','endDate','sales_merchant_geadia','sales_merchant_wallet'));
    }
    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Distributor $distributor)
    {
        return view('distributor::distributors.edit',compact('distributor'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(DistributorRequest $request, Distributor $distributor)
    {
        $updated = $this->repository->update($request, $distributor);
        return $updated ?
            redirect()->route('admin.distributors.index')->with('success', trans('messages.updateOK')) :
            redirect()->route('admin.distributors.index')->with('warning', trans('messages.updateNO'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Request $request)
    {
        $deleted = $this->repository->destroy($request);
        $url = route('admin.distributors.index');

        return $deleted
            ? json_encode(['code' => '1', 'url' => $url])
            : json_encode(['code' => '0', 'message' => 'نأسف لحدوث هذا الخطأ, برجاء المحاولة لاحقًا']);
    }
    public function destroy_token(Request $request)
    {
        $deleted = $this->repository->destroy_token($request);
        $url = route('admin.distributors.index');

        return json_encode(['code' => '1', 'url' => $url]);
    }
    public function destroy_selected_rows(Request $request)
    {
        $deleted = $this->repository->destroy_selected_rows($request);
        $url = route('admin.distributors.index');

        return $deleted
            ? json_encode(['code' => '1', 'url' => $url])
            : json_encode(['code' => '0', 'message' => 'نأسف لحدوث هذا الخطأ, برجاء المحاولة لاحقًا']);
    }
    public function showChangePasswordForm(Distributor $distributor){
        return view('distributor::distributors.change_password', compact('distributor'));

    }
    public function updateAdminPassword(Request $request, Distributor $distributor) {

        $request->validate([
            'new_password'      => 'required|min:3|max:191',
            'password_confirm'  => 'same:new_password',
        ]);

        $updated =    $this->repository->update_password($request,$distributor);
        return $updated ?
            redirect()->route('admin.distributors.index')->with('success', 'تم تغيير كلمة مرور الموزع بنجاح') :
            redirect()->route('admin.distributors.index')->with('warning', 'حدث خطأ ما, برجاء المحاولة مرة اخرى');
    }
}
