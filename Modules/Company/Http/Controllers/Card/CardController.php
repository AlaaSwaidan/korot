<?php

namespace Modules\Company\Http\Controllers\Card;

use App\Exports\CardExport;
use App\Exports\CardTransactionExport;
use App\Exports\CollectionExport;
use App\Exports\ImportedCardExport;
use App\Imports\CardsImport;
use App\Models\Card;
use App\Models\DuplicatedCard;
use App\Models\Order;
use App\Models\Package;
use App\Models\Store;
use App\Models\UploadedCard;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Company\Http\Requests\CardImportRequest;
use Modules\Company\Http\Requests\CardRequest;
use Modules\Company\Http\Requests\DeleteAllCardsRequest;
use Modules\Company\Repositories\CardRepository;

class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public $repository;
    public function __construct()
    {
        $this->middleware('permission:view_cards');
        $this->middleware('permission:create_cards', ['only' => ['create', 'store']]);
        $this->middleware('permission:update_cards', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_cards', ['only' => ['destroy','destroy_selected_rows']]);
        $this->middleware('permission:sold_cards', ['only' => ['sold_cards']]);
        $this->middleware('permission:mostSeller_cards', ['only' => ['most_seller_cards']]);
        $this->middleware('permission:lessSelle_cards', ['only' => ['lowest_seller_cards']]);

        $this->repository = new CardRepository();
    }

    public function index(Package $package)
    {
        $data = $this->repository->index($package);
        $name = $package->category->company->name['ar'].'/'.$package->category->name['ar'].'/'.$package->name['ar'];
        $count = $package->cards()->Order()->NotSold()->count();
        return view('company::cards.index',compact('package','data','name','count'));
    }
    public function search_card(Request $request ,Package $package)
    {
        $name = $package->category->company->name['ar'].'/'.$package->category->name['ar'].'/'.$package->name['ar'];

        $serial_num = $request->serial_num;
        $data = Card::Order()->NotSold();
        if($serial_num){
            $data = $data->where(function ($q) use($serial_num){
                $q->where('card_number', 'LIKE', "%$serial_num%");
                $q->orWhere('serial_number', 'LIKE', "%$serial_num%");
            });
        }

        $data = $data->paginate(20)->appends(request()->except('page'));
        return view('company::cards.index',compact('package','data','name','serial_num'));
    }
    //uploaded_card_index
    public function uploaded_card_index(Package $package)
    {
        $data = UploadedCard::where('error',0)->paginate(10);
        $name = $package->category->company->name['ar'].'/'.$package->category->name['ar'].'/'.$package->name['ar'];
        $count = $package->cards()->Order()->NotSold()->count();
        return view('company::cards.uploaded_card_index',compact('package','data','name','count'));
    }
    public function uploaded_card_index_errors(Package $package)
    {
        $data = UploadedCard::where('error',1)->paginate(10);
        $name = $package->category->company->name['ar'].'/'.$package->category->name['ar'].'/'.$package->name['ar'];
        $error = 1;
        $count = $package->cards()->Order()->NotSold()->count();
        return view('company::cards.uploaded_card_index',compact('package','error','data','name','count'));
    }
    public function sold_cards(){

        $data = $this->repository->sold();
        return view('company::sold_cards.index',compact('data'));
    }
    public function generate_pdf(Card $card)
    {

        $pdf = $this->repository->generate_pdf($card);
        return $pdf;

    }
    public function sold_cards_recover(Request $request){

        $data = $this->repository->restore_sold_card($request);
        return $data
            ? json_encode(['code' => '1', 'url' => $data])
            : json_encode(['code' => '0', 'message' => 'نأسف لحدوث هذا الخطأ, برجاء المحاولة لاحقًا']);
    }
    public function imported_cards(Request $request){


        $data = Card::Order()->where('imported',1);
        if($request->from_date && $request->to_date == null){
            $data = $data->whereDate('created_at',$request->from_date);
        }if($request->from_date && $request->to_date){
            $data = $data->whereBetween(DB::raw('DATE(created_at)'), [$request->from_date, $request->to_date]);
        }
        if($request->package_id){
            $data = $data->where('package_id',$request->package_id);
        }
        if ($request->company_id && $request->category_id == null && $request->package_id == null ){
            $stores = Store::where('id',$request->company_id)->pluck('id')->toArray();
            $categories = Store::where('parent_id',$stores)->pluck('id')->toArray();
            $packages = Package::whereIn('store_id',$categories)->orderBy('id','desc')->pluck('id')->toArray();
            $data = $data->whereIn('package_id',$packages);
        }
        if ($request->company_id && $request->category_id && $request->package_id == null ){
            $categories = Store::where('id',$request->category_id)->pluck('id')->toArray();
            $packages = Package::whereIn('store_id',$categories)->orderBy('id','desc')->pluck('id')->toArray();
            $data = $data->whereIn('package_id',$packages);
        }
        $count = $data->count();

        $data = $data->paginate(50)->appends(request()->except('page'));

        $companies = Store::Order()->Main()->get();
        $category_id = $request->category_id;
        $package_id = $request->package_id;
        $company_id = $request->company_id;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        return view('company::imported.index',compact('data','to_date','from_date','count','companies','category_id','package_id','company_id'));
    }
    public function duplicated_cards(Request $request){


        $data = DuplicatedCard::orderBy('id','desc');

        if($request->from_date && $request->to_date == null){
            $data = $data->whereDate('created_at',$request->from_date);
        }if($request->from_date && $request->to_date){
            $data = $data->whereBetween(DB::raw('DATE(created_at)'), [$request->from_date, $request->to_date]);
        }
        if($request->package_id){
            $data = $data->where('package_id',$request->package_id);
        }
        if ($request->company_id && $request->category_id == null && $request->package_id == null ){
            $stores = Store::where('id',$request->company_id)->pluck('id')->toArray();
            $categories = Store::where('parent_id',$stores)->pluck('id')->toArray();
            $packages = Package::whereIn('store_id',$categories)->orderBy('id','desc')->pluck('id')->toArray();
            $data = $data->whereIn('package_id',$packages);
        }
        if ($request->company_id && $request->category_id && $request->package_id == null ){
            $categories = Store::where('id',$request->category_id)->pluck('id')->toArray();
            $packages = Package::whereIn('store_id',$categories)->orderBy('id','desc')->pluck('id')->toArray();
            $data = $data->whereIn('package_id',$packages);
        }
        $count = $data->count();

        $data = $data->paginate(50)->appends(request()->except('page'));

        $companies = Store::Order()->Main()->get();
        $category_id = $request->category_id;
        $package_id = $request->package_id;
        $company_id = $request->company_id;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        return view('company::duplicated.index',compact('data','to_date','from_date','count','companies','category_id','package_id','company_id'));
    }
    public function reports_cards(Request $request){


        $duplicated = DuplicatedCard::orderBy('id','desc');
        $imported = Card::where('imported',1);

        if($request->from_date && $request->to_date == null){
            $duplicated = $duplicated->whereDate('created_at',$request->from_date);
            $imported = $imported->whereDate('cards.created_at',$request->from_date);
        }if($request->from_date && $request->to_date){
            $duplicated = $duplicated->whereBetween(DB::raw('DATE(created_at)'), [$request->from_date, $request->to_date]);
            $imported = $imported->whereBetween(DB::raw('DATE(cards.created_at)'), [$request->from_date, $request->to_date]);
        }
        if($request->package_id){
            $duplicated = $duplicated->where('package_id',$request->package_id);
            $imported = $imported->where('cards.package_id',$request->package_id);
        }
        if ($request->company_id && $request->category_id == null && $request->package_id == null ){
            $stores = Store::where('id',$request->company_id)->pluck('id')->toArray();
            $categories = Store::where('parent_id',$stores)->pluck('id')->toArray();
            $packages = Package::whereIn('store_id',$categories)->orderBy('id','desc')->pluck('id')->toArray();
            $duplicated = $duplicated->whereIn('package_id',$packages);
            $imported = $imported->whereIn('cards.package_id',$packages);
        }
        if ($request->company_id && $request->category_id && $request->package_id == null ){
            $categories = Store::where('id',$request->category_id)->pluck('id')->toArray();
            $packages = Package::whereIn('store_id',$categories)->orderBy('id','desc')->pluck('id')->toArray();
            $duplicated = $duplicated->whereIn('package_id',$packages);
            $imported = $imported->whereIn('cards.package_id',$packages);
        }
        $duplicated_count = $duplicated->count();
        $imported_count = $imported->count();
        $data = $imported
            ->join('packages', 'cards.package_id', '=', 'packages.id')
            ->selectRaw('cards.package_id, COUNT(cards.id) as total_cards, SUM(packages.cost) as total_cost, MAX(cards.id) as max_id')
            ->groupBy('cards.package_id')
            ->orderBy('max_id','DESC')->get();

        $companies = Store::Order()->Main()->get();
        $category_id = $request->category_id;
        $package_id = $request->package_id;
        $company_id = $request->company_id;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $url = route('admin.duplicated-cards.index','?category_id='.$category_id.'&package_id='.$package_id.'&company_id='.$company_id.'&from_date='.$from_date.'&to_date='.$to_date);
        return view('company::reports.index',compact('duplicated_count','url','data','imported_count','to_date','from_date','companies','category_id','package_id','company_id'));
    }
    public function reports_sales_cards(Request $request){

        $cards = Card::query();
        if($request->from_date && $request->to_date == null){
            $cards = $cards->whereDate('cards.updated_at',$request->from_date);
        }if($request->from_date && $request->to_date){
            $cards = $cards->whereBetween(DB::raw('DATE(cards.updated_at)'), [$request->from_date, $request->to_date]);
        }
        if($request->package_id){
            $cards = $cards->where('cards.package_id',$request->package_id);
        }
        if ($request->company_id && $request->category_id == null && $request->package_id == null ){
            $stores = Store::where('id',$request->company_id)->pluck('id')->toArray();
            $categories = Store::where('parent_id',$stores)->pluck('id')->toArray();
            $packages = Package::whereIn('store_id',$categories)->orderBy('id','desc')->pluck('id')->toArray();
            $cards = $cards->whereIn('cards.package_id',$packages);
        }
        if ($request->company_id && $request->category_id && $request->package_id == null ){
            $categories = Store::where('id',$request->category_id)->pluck('id')->toArray();
            $packages = Package::whereIn('store_id',$categories)->orderBy('id','desc')->pluck('id')->toArray();
            $cards = $cards->whereIn('cards.package_id',$packages);
        }

        $data = $cards
            ->join('packages', 'cards.package_id', '=', 'packages.id')
                 ->selectRaw("
        cards.package_id,
        COUNT(cards.id) as total_cards,

        -- Sold cards per day
        COUNT(CASE WHEN sold = 1 AND DATE(cards.updated_at) = CURDATE() THEN 1 ELSE NULL END) as sold_per_day,

        -- Sold cards per week
        COUNT(CASE WHEN sold = 1 AND YEARWEEK(cards.updated_at, 1) = YEARWEEK(CURDATE(), 1) THEN 1 ELSE NULL END) as sold_per_week,

        -- Sold cards per month
        COUNT(CASE WHEN sold = 1 AND MONTH(cards.updated_at) = MONTH(CURDATE()) AND YEAR(cards.updated_at) = YEAR(CURDATE()) THEN 1 ELSE NULL END) as sold_per_week,

    -- Total unsold cards (independent of date filter)
        (SELECT COUNT(*) FROM cards AS unsold_cards WHERE unsold_cards.package_id = cards.package_id AND unsold_cards.sold = 0) as total_unsold,


        -- Total cost of sold cards
        SUM(CASE WHEN sold = 1 THEN packages.cost ELSE 0 END) as total_sold_cost,

        -- Total card price of sold cards
        SUM(CASE WHEN sold = 1 AND DATE(cards.updated_at) = CURDATE() THEN packages.card_price ELSE 0 END) as total_card_price,

        MAX(cards.id) as max_id
    ")
                 ->groupBy('cards.package_id')
                 ->orderBy('max_id', 'DESC')
                 ->get();

        $companies = Store::Order()->Main()->get();

        $category_id = $request->category_id;
        $package_id = $request->package_id;
        $company_id = $request->company_id;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        return view('company::reports.sales_card',compact('data','to_date','from_date','companies','category_id','package_id','company_id'));

    }
    public function reports_sales_cards_search(Request $request){

        $cards = Card::query();

        if($request->from_date && $request->to_date == null){
            $cards = $cards->whereDate('cards.updated_at',$request->from_date);
        }if($request->from_date && $request->to_date){
            $cards = $cards->whereBetween(DB::raw('DATE(cards.updated_at)'), [$request->from_date, $request->to_date]);
        }
        if($request->package_id){
            $cards = $cards->where('cards.package_id',$request->package_id);
        }
        if ($request->company_id && $request->category_id == null && $request->package_id == null ){
            $stores = Store::where('id',$request->company_id)->pluck('id')->toArray();
            $categories = Store::where('parent_id',$stores)->pluck('id')->toArray();
            $packages = Package::whereIn('store_id',$categories)->orderBy('id','desc')->pluck('id')->toArray();
            $cards = $cards->whereIn('cards.package_id',$packages);
        }
        if ($request->company_id && $request->category_id && $request->package_id == null ){
            $categories = Store::where('id',$request->category_id)->pluck('id')->toArray();
            $packages = Package::whereIn('store_id',$categories)->orderBy('id','desc')->pluck('id')->toArray();
            $cards = $cards->whereIn('cards.package_id',$packages);
        }

        $data = $cards
            ->join('packages', 'cards.package_id', '=', 'packages.id')
            ->selectRaw("
        cards.package_id,
        COUNT(cards.id) as total_cards,

        -- Total sold cards
        COUNT(CASE WHEN sold = 1 THEN 1 ELSE NULL END) as total_sold,

        -- Total unsold cards (independent of date filter)
        (SELECT COUNT(*) FROM cards AS unsold_cards WHERE unsold_cards.package_id = cards.package_id AND unsold_cards.sold = 0) as total_unsold,

        MAX(cards.id) as max_id
    ")
            ->groupBy('cards.package_id')
            ->orderBy('max_id', 'DESC')

            ->get();

        $companies = Store::Order()->Main()->get();
        $category_id = $request->category_id;
        $package_id = $request->package_id;
        $company_id = $request->company_id;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        return view('company::reports.sales_card_search',compact('data','to_date','from_date','companies','category_id','package_id','company_id'));
    }
//    public function saled_cards(Request $request){
//
//
////        $imported = Order::where('parent_id','!=',null)->where('paid_order',"paid")->whereIn('cart_type',["imported","inserted",null]);
//        // 1) Base query with general constraints
//        $baseQuery = Order::query()
//            ->whereNotNull('parent_id')
//            ->where('paid_order', 'paid');
//
//// 2) Apply the date filter logic **once** in the base query
//        if (!$request->from_date && !$request->to_date) {
//            // current month
//            $baseQuery->whereBetween('updated_at', [
//                Carbon::now()->startOfMonth(),
//                Carbon::now()->endOfMonth()
//            ]);
//        } elseif ($request->from_date && !$request->to_date) {
//            // single day
//            $baseQuery->whereDate('updated_at', $request->from_date);
//        } elseif ($request->from_date && $request->to_date) {
//            // date range
//            $baseQuery->whereDate('updated_at', '>=', $request->from_date)
//                ->whereDate('updated_at', '<=', $request->to_date);
//        }
//
//// 3) Package filter
//        if ($request->package_id) {
//            $baseQuery->where('package_id', $request->package_id);
//        }
//
//// 4) Now clone and apply specific cart_type filters
//
//// likecard
//        $likecard = (clone $baseQuery)->where('cart_type', 'likecard');
//        $likecard_price = $likecard->sum(DB::raw("COALESCE(card_price, 0)"));
//        $likecard_merchant_price = $likecard->sum(DB::raw("COALESCE(merchant_price, 0)"));
//        $likecard_cost = $likecard->sum(DB::raw("COALESCE(cost, 0)"));
//        $likecard_profits = $likecard_merchant_price - $likecard_cost;
//
//// stc
//        $stc = (clone $baseQuery)->where('cart_type', 'stc');
//        $stc_price = $stc->sum(DB::raw("COALESCE(card_price, 0)"));
//        $stc_merchant_price = $stc->sum(DB::raw("COALESCE(merchant_price, 0)"));
//        $stc_cost = $stc->sum(DB::raw("COALESCE(cost, 0)"));
//        $stc_profits = $stc_merchant_price - $stc_cost;
//
//// imported  (imported, inserted, or NULL)
//        $imported = (clone $baseQuery)->where(function ($query) {
//            $query->whereIn('cart_type', ["imported", "inserted"])
//                ->orWhereNull('cart_type');
//        });
//        $imported_price = $imported->sum(DB::raw("COALESCE(card_price, 0)"));
//        $imported_merchant_price = $imported->sum(DB::raw("COALESCE(merchant_price, 0)"));
//        $imported_cost = $imported->sum(DB::raw("COALESCE(cost, 0)"));
//        $imported_profits = $imported_merchant_price - $imported_cost;
//        $from_date = $request->from_date;
//        $to_date = $request->to_date;
//        return view('company::saled.index',compact('likecard_price','likecard_merchant_price','stc_price','stc_merchant_price'
//            ,'imported_price','imported_merchant_price','imported_profits','stc_profits','likecard_profits','to_date','from_date'));
//    }
    public function saled_cards(Request $request)
    {
        // 1) Base query with general constraints
        $baseQuery = Order::query()
            ->whereNotNull('parent_id')
            ->where('paid_order', 'paid');

        // 2) Apply the date filter logic **once** in the base query
        if (!$request->from_date && !$request->to_date) {
            // current month
            $baseQuery->whereBetween('updated_at', [
                Carbon::now()->startOfMonth(),
                Carbon::now()->endOfMonth()
            ]);
        } elseif ($request->from_date && !$request->to_date) {
            // single day
            $baseQuery->whereDate('updated_at', $request->from_date);
        } elseif ($request->from_date && $request->to_date) {
            // date range
            $baseQuery->whereDate('updated_at', '>=', $request->from_date)
                ->whereDate('updated_at', '<=', $request->to_date);
        }

        // 3) Apply package filter if exists
        if ($request->package_id) {
            $baseQuery->where('package_id', $request->package_id);
        }

        // 4) Aggregate and filter by cart_type
        $aggregates = $baseQuery->select(
            DB::raw('
            SUM(CASE WHEN cart_type = "likecard" THEN COALESCE(card_price, 0) ELSE 0 END) AS likecard_price,
            SUM(CASE WHEN cart_type = "likecard" THEN COALESCE(merchant_price, 0) ELSE 0 END) AS likecard_merchant_price,
            SUM(CASE WHEN cart_type = "likecard" THEN COALESCE(cost, 0) ELSE 0 END) AS likecard_cost,
            SUM(CASE WHEN cart_type = "stc" THEN COALESCE(card_price, 0) ELSE 0 END) AS stc_price,
            SUM(CASE WHEN cart_type = "stc" THEN COALESCE(merchant_price, 0) ELSE 0 END) AS stc_merchant_price,
            SUM(CASE WHEN cart_type = "stc" THEN COALESCE(cost, 0) ELSE 0 END) AS stc_cost,
            SUM(CASE WHEN cart_type IN ("imported", "inserted") OR cart_type IS NULL THEN COALESCE(card_price, 0) ELSE 0 END) AS imported_price,
            SUM(CASE WHEN cart_type IN ("imported", "inserted") OR cart_type IS NULL THEN COALESCE(merchant_price, 0) ELSE 0 END) AS imported_merchant_price,
            SUM(CASE WHEN cart_type IN ("imported", "inserted") OR cart_type IS NULL THEN COALESCE(cost, 0) ELSE 0 END) AS imported_cost
        ')
        )
            ->first(); // Aggregating the sums in a single query

        // 5) Calculate profits
        $aggregates->likecard_profits = $aggregates->likecard_merchant_price - $aggregates->likecard_cost;
        $aggregates->stc_profits = $aggregates->stc_merchant_price - $aggregates->stc_cost;
        $aggregates->imported_profits = $aggregates->imported_merchant_price - $aggregates->imported_cost;

        // Get the request dates
        $from_date = $request->from_date;
        $to_date = $request->to_date;

        // Return the results
        return view('company::saled.index', compact(
            'aggregates',
            'from_date',
            'to_date'
        ));
    }

    public function search(Request $request){

        $card_name = $request->card_num;
        $transaction_id = $request->transaction_id;
        $orders = Order::where('transaction_id',$transaction_id)->pluck('serial_number');
        $data = Card::Order()->Sold();
        if($card_name){
            $data = $data->where(function ($q) use($card_name){
                $q->where('card_number', 'LIKE', "%$card_name%");
                $q->orWhere('serial_number', 'LIKE', "%$card_name%");
            });
        }if($transaction_id){
            $data = $data->whereIn('serial_number',$orders);
        }

        $data = $data->paginate(20)->appends(request()->except('page'));
        return view('company::sold_cards.index',compact('data','transaction_id','card_name'));
    }
    public function package_sold_cards(Package $package){

        $data = $this->repository->package_sold_cards($package);
        return view('company::sold_cards.index',compact('data'));
    }
    public function most_seller_cards(Request $request){

        $data = $this->repository->most_seller_cards($request);
        return view('company::sold_cards.most_seller_cards',compact('data'));
    }
    public function lowest_seller_cards(){

        $data = $this->repository->lowest_seller_cards();
        return view('company::sold_cards.lowest_seller_cards',compact('data'));
    }
    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(Package $package)
    {
        return view('company::cards.create',compact('package'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(CardRequest $request,Package $package)
    {
        $data = $this->repository->store($request,$package);
        return $data ?
            redirect()->route('admin.cards.index',$package->id)->with('success', trans('messages.addOK')) :
            redirect()->route('admin.cards.index',$package->id)->with('warning', trans('messages.addNO'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(Package $package)
    {
        return view('company::cards.show',compact('package'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Card $card)
    {
        return view('company::cards.edit',compact('card'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(CardRequest $request, Card $card)
    {
        $updated = $this->repository->update($request, $card);
        return $updated ?
            redirect()->route('admin.cards.index',$card->package_id)->with('success', trans('messages.updateOK')) :
            redirect()->route('admin.cards.index',$card->package_id)->with('warning', trans('messages.updateNO'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Request $request) {
        $data = $this->repository->destroy($request);
        return $data
            ? json_encode(['code' => '1', 'url' => $data])
            : json_encode(['code' => '0', 'message' => 'نأسف لحدوث هذا الخطأ, برجاء المحاولة لاحقًا']);
    }
    public function delete_all_store(DeleteAllCardsRequest $request) {
        $data = $this->repository->delete_all_store($request);

        return redirect()->route('admin.cards.index',$request->package)->with('success', 'تم الحذف بنجاح');
    }
    public function destroy_selected_rows(Request $request) {
        $data = $this->repository->destroy_selected_rows($request);
        return $data
            ? json_encode(['code' => '1', 'url' => $data])
            : json_encode(['code' => '0', 'message' => 'نأسف لحدوث هذا الخطأ, برجاء المحاولة لاحقًا']);
    }
    public function export(){
        return Excel::download(new CardExport(), 'cards_'.randNumber(4)."."."xlsx");
    }
    public function import(CardImportRequest $request){
        $package = Package::find($request->package);
        $name = $package->category->company->name['ar'].'/'.$package->category->name['ar'].'/'.$package->name['ar'];
        if ($request->confirm_name != $name){
            return back()->withInput()->with('danger',"كلمة التأكيد غير صحيحة");
        }
        $file = $request->file('upload_excel');

        if ($file->getSize() == 0) {
            return redirect()->back()->with('danger', 'الملف فارغ');
        }
        // Import Excel file into a collection
        $data = Excel::toArray([], $file)[0];

        // Check if the collection is empty
        if (empty($data) || count($data) == 1) {
            return redirect()->back()->with('danger', 'الملف لا يحتوى علي بيانات ');
        }


        Excel::import(new CardsImport($request->package), $request->upload_excel);

        return redirect()->route('admin.uploaded-card-index.index',$request->package)->with('success', 'تم الرفع بنجاح');
    }
    public function excel(Request $request){

        return Excel::download(new CardTransactionExport($request), 'cards_'.randNumber(4)."."."xlsx");

    }
    public function cards_excel(Request $request){

        return Excel::download(new ImportedCardExport($request), 'imported_cards_'.randNumber(4)."."."xlsx");
    }
}
