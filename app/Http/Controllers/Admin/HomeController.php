<?php

namespace App\Http\Controllers\Admin;


use App\Exports\CardSoldExport;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminNotification;
use App\Models\Bank;
use App\Models\Card;
use App\Models\Complaint;
use App\Models\Contact;
use App\Models\Distributor;
use App\Models\Employee;
use App\Models\EmployeeNotification;
use App\Models\GeadiaWallet;
use App\Models\Merchant;
use App\Models\NewsLetter;
use App\Models\Order;
use App\Models\OrderTransfer;
use App\Models\Package;
use App\Models\PullBalance;
use App\Models\ReturnMoney;
use App\Models\Room;
use App\Models\Service;
use App\Models\Statistic;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Transfers\Entities\Transfer;


class HomeController extends Controller
{

    public function home() {

        $admins= Admin::count();

        //Optimization

        $merchantStats = Merchant::selectRaw('
                    COUNT(*) as total,
                    SUM(CASE WHEN confirmed = 0 THEN 1 ELSE 0 END) as not_active,
                    SUM(CASE WHEN confirmed = 1 THEN 1 ELSE 0 END) as active
                ')->first();
        $Not_active_merchants = $merchantStats->not_active;
        $percent = $merchantStats->total == 0 ? 0 : ($merchantStats->active / $merchantStats->total) * 100;

        $result = DB::table('packages')
            ->join('cards', 'packages.id', '=', 'cards.package_id')
            ->where('packages.status', 1)
            ->selectRaw('
                SUM(CASE WHEN cards.sold = 0 THEN packages.cost ELSE 0 END) as total_cost,
                SUM(packages.cost) as all_total_cost
            ')
            ->first();

        $costs = $result->total_cost;
        $all_costs = $result->all_total_cost;


        //End Optimization


        $statistics = Statistic::find(1);

        $settings = Cache::remember('settings', 3600, function () {
            return settings();
        });

        $active_sellers = Order::where('parent_id', null)
            ->whereBetween('created_at', [
                Carbon::now()->subDays($settings->transaction_days),
                Carbon::now(),
            ])
            ->groupBy('merchant_id')
            ->havingRaw('SUM(count) >= ?', [$settings->transaction_count])
            ->count(DB::raw('DISTINCT merchant_id'));

        $inactive_sellers = Order::where('parent_id', null)
            ->whereBetween('created_at', [
                Carbon::now()->subDays($settings->transaction_lowest_day),
                Carbon::now(),
            ])
            ->groupBy('merchant_id')
            ->havingRaw('SUM(count) <= ?', [$settings->transaction_lowest_count])
            ->count(DB::raw('DISTINCT merchant_id'));

//        $most_merchants_sellers = Order::whereNotNull('parent_id')
//            ->whereHas('merchant', function ($q) {
//                $q->whereNull('deleted_at');
//            })
//            ->select('merchant_id',
//                DB::raw('SUM(count) as sums'),
//                DB::raw('SUM(card_price) as total'),
//                DB::raw('SUM(card_price) - SUM(merchant_price) as profits')
//            )
//            ->groupBy('merchant_id')
//            ->orderByDesc('sums')
//            ->take(10)
//            ->get();
//
//        $lowest_merchants_sellers = Order::whereNotNull('parent_id')
//            ->whereHas('merchant', function ($q) {
//                $q->whereNull('deleted_at');
//            })
//            ->select('merchant_id',
//                DB::raw('SUM(count) as sums'),
//                DB::raw('SUM(card_price) as total'),
//                DB::raw('SUM(card_price) - SUM(merchant_price) as profits'
//                ))
//            ->groupBy('merchant_id')
//            ->orderBy('sums')
//            ->take(10)
//            ->get();

        return view('admin.dashboard.home',compact('admins','all_costs','costs','Not_active_merchants','inactive_sellers','active_sellers','statistics','percent'));



        //return view('admin.dashboard.home',compact('admins','all_costs','costs','Not_active_merchants','inactive_sellers','active_sellers','statistics','percent','most_merchants_sellers','lowest_merchants_sellers'));

        //$packages = Package::where('status', 1)->get();

        //$costs = $packages->sum('total_cost');
        //$all_costs = $packages->sum('all_total_cost');




//         $Not_active_merchants= Merchant::where('confirmed',0)->count();
//         $statistics = Statistic::find(1);
//         $costs = Package::where('status',1)->get()->sum('total_cost');
//         $all_costs = Package::where('status',1)->get()->sum('all_total_cost');
//         $percent  = Merchant::count() == 0 ? 0 :Merchant::where('confirmed',1)->count() / Merchant::count() * 100;


//         $active_sellers =   Order::where('parent_id',null)->select('merchant_id', DB::raw('sum(count) as sums'))
//             ->whereBetween('created_at',
//                 [Carbon::now()->subDays(settings()->transaction_days), Carbon::now()]
//             )
//             ->groupBy('merchant_id')
//             ->havingRaw('sum(count) >='.settings()->transaction_count)
//             ->with('merchant')
//             ->count();
//         $inactive_sellers =   Order::where('parent_id',null)->select('merchant_id', DB::raw('sum(count) as sums'))
//             ->whereBetween('created_at',
//                 [Carbon::now()->subDays(settings()->transaction_lowest_day), Carbon::now()]
//             )
//             ->groupBy('merchant_id')
//             ->havingRaw('sum(count) <='.settings()->transaction_lowest_count)
//             ->with('merchant')
//             ->count();

//       $most_merchants_sellers =  Order::where('parent_id' ,'!=',null)->select('merchant_id', DB::raw('sum(count) as sums , sum(card_price) as total , sum(card_price) - sum(merchant_price) as profits'))
// //            ->whereDate('created_at', Carbon::today())
//               ->whereHas('merchant',function ($q){
//                   $q->where('deleted_at',null);
//           })
//             ->orderBy('sums','DESC')
//             ->take(10)
//             ->groupBy('merchant_id')
//             ->with('merchant')
//             ->get();
//       $lowest_merchants_sellers =  Order::where('parent_id' ,'!=',null)->select('merchant_id', DB::raw('sum(count) as sums , sum(card_price) as total , sum(card_price) - sum(merchant_price) as profits'))
// //            ->whereDate('created_at', Carbon::today())
//           ->whereHas('merchant',function ($q){
//               $q->where('deleted_at',null);
//           })
//             ->orderBy('sums','ASC')
//             ->take(10)
//             ->groupBy('merchant_id')
//             ->with('merchant')
//             ->get();
        return view('admin.dashboard.home',compact('admins'));


    }
    public function search_most(Request $request){
        $most_merchants_sellers =  Order::where('parent_id',null)->select('merchant_id', DB::raw('sum(count) as sums , sum(card_price) as total , sum(card_price) - sum(merchant_price) as profits'))
//            ->whereDate('created_at', Carbon::today())
            ->orderBy('sums','DESC')
            ->take(10)
            ->groupBy('merchant_id')
            ->with('merchant');

        if ($request->time == "current_month"){
            $most_merchants_sellers = $most_merchants_sellers->whereBetween('created_at',
                [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]
            );
        }
        if ($request->time == "3_month"){
            $dateS = Carbon::now()->startOfMonth()->subMonth(3);
            $dateE = Carbon::now()->startOfMonth();
            $most_merchants_sellers = $most_merchants_sellers->whereBetween('created_at',
                [$dateS, $dateE]
            );
        }
        if ($request->time == "exact_time"){
            $startDate = Carbon::parse($request->from_date);
            $endDate = Carbon::parse($request->to_date);
            $most_merchants_sellers = $most_merchants_sellers->whereBetween(DB::raw('DATE(created_at)'), [$startDate, $endDate]);
        }
        $most_merchants_sellers = $most_merchants_sellers->get();
        $view = view('admin.dashboard._seller',compact('most_merchants_sellers'))->render();
        return response()->json(['html'=>$view]);
    }
    public function search_lowest(Request $request){
        $lowest_merchants_sellers =  Order::where('parent_id',null)->select('merchant_id', DB::raw('sum(count) as sums , sum(card_price) as total , sum(card_price) - sum(merchant_price) as profits'))
//            ->whereDate('created_at', Carbon::today())
            ->orderBy('sums','ASC')
            ->take(10)
            ->groupBy('merchant_id')
            ->with('merchant');

        if ($request->time == "current_month"){
            $lowest_merchants_sellers = $lowest_merchants_sellers->whereBetween('created_at',
                [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]
            );
        }
        if ($request->time == "3_month"){
            $dateS = Carbon::now()->startOfMonth()->subMonth(3);
            $dateE = Carbon::now()->startOfMonth();
            $lowest_merchants_sellers = $lowest_merchants_sellers->whereBetween('created_at',
                [$dateS, $dateE]
            );
        }
        if ($request->time == "exact_time"){
            $startDate = Carbon::parse($request->from_date);
            $endDate = Carbon::parse($request->to_date);
            $lowest_merchants_sellers = $lowest_merchants_sellers->whereBetween(DB::raw('DATE(created_at)'), [$startDate, $endDate]);
        }
        $lowest_merchants_sellers = $lowest_merchants_sellers->get();
        $view = view('admin.dashboard._lowest_seller',compact('lowest_merchants_sellers'))->render();
        return response()->json(['html'=>$view]);
    }
    public function home_search(Request $request){
        $time = $request->time;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $admins= Admin::count();
        $Not_active_merchants= Merchant::where('confirmed',0)->count();
        $statistics = Statistic::find(1);
        $percent  = Merchant::count() == 0 ? 0 :Merchant::where('confirmed',1)->count() / Merchant::count() * 100;
        $geaida =  GeadiaWallet::query();
        $active_sellers =   Order::where('parent_id',null)->select('merchant_id', DB::raw('sum(count) as sums'))
            ->whereBetween('created_at',
                [Carbon::now()->subDays(settings()->transaction_days), Carbon::now()]
            )
            ->groupBy('merchant_id')
            ->havingRaw('sum(count) >='.settings()->transaction_count)
            ->with('merchant')
            ->count();
        $inactive_sellers =   Order::where('parent_id',null)->select('merchant_id', DB::raw('sum(count) as sums'))
            ->whereBetween('created_at',
                [Carbon::now()->subDays(settings()->transaction_lowest_day), Carbon::now()]
            )
            ->groupBy('merchant_id')
            ->havingRaw('sum(count) <='.settings()->transaction_lowest_count)
            ->with('merchant')
            ->count();

        $most_merchants_sellers =  Order::where('parent_id',null)->select('merchant_id', DB::raw('sum(count) as sums , sum(card_price) as total , sum(card_price) - sum(merchant_price) as profits'))
//            ->whereDate('created_at', Carbon::today())
            ->orderBy('sums','DESC')
            ->take(10)
            ->groupBy('merchant_id')
            ->with('merchant')
            ->get();
        $lowest_merchants_sellers =  Order::where('parent_id',null)->select('merchant_id', DB::raw('sum(count) as sums , sum(card_price) as total , sum(card_price) - sum(merchant_price) as profits'))
//            ->whereDate('created_at', Carbon::today())
            ->orderBy('sums','ASC')
            ->take(10)
            ->groupBy('merchant_id')
            ->with('merchant')
            ->get();



        //$orders = Order::where('parent_id',null)->orderBy('id','desc');

        $transfers = Transfer::orderBy('id','desc');

        if ($request->time == "today"){
            //$orders = $orders->whereDate('created_at',Carbon::now());
            $transfers = $transfers->whereDate('created_at',Carbon::now());
            $geaida = $geaida->whereDate('created_at',Carbon::now());
        }
        if ($request->time == "current_month"){
            /*$orders = $orders->whereBetween('created_at',
                [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]
            );*/
            $transfers = $transfers->whereBetween('created_at',
                [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]
            );
            $geaida = $geaida->whereBetween('created_at',
                [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]
            );
        }
        if ($request->time == "month_ago"){
            /*$orders = $orders->whereMonth(
                'created_at', '=', Carbon::now()->subMonth()->month
            );*/
            $transfers = $transfers->whereMonth(
                'created_at', '=', Carbon::now()->subMonth()->month
            );
            $geaida = $geaida->whereMonth(
                'created_at', '=', Carbon::now()->subMonth()->month
            );
        }
        if ($request->time == "exact_time"){
            $startDate = Carbon::parse($request->from_date);
            $endDate = Carbon::parse($request->to_date);
            /*$orders = $orders->whereBetween(DB::raw('DATE(created_at)'), [$startDate, $endDate]);*/
            $transfers = $transfers->whereBetween(DB::raw('DATE(created_at)'), [$startDate, $endDate]);
            $geaida = $geaida->whereBetween(DB::raw('DATE(created_at)'), [$startDate, $endDate]);
        }

        $transfers = $transfers->orderBy('id','asc')->get();
        $geaida = $geaida->sum('balance');


        return view('admin.dashboard.home',compact('admins','Not_active_merchants'
            ,'inactive_sellers','active_sellers','statistics','percent'
            ,'most_merchants_sellers','lowest_merchants_sellers','time','transfers','from_date','to_date','geaida'));

    }
}
