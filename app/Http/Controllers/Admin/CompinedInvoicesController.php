<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

class CompinedInvoicesController extends Controller
{
//    public function index()
//    {
//        $specificToken = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwO';
//        $apiUrl = route('get-all-invoices');
//        $date = request('date', now()->format('Y-m'));
//        $page = request('page', 1);
//        $perPage = 1;
//
//        $response = Http::withToken($specificToken)->get($apiUrl, [
//            'date' => $date,
//            'per_page' => $perPage,
//            'page' => $page,
//        ]);
//
//        if ($response->failed()) {
//            return back()->with('error', 'فشل في جلب البيانات من واجهة البرمجة.');
//        }
//
//        $json = $response->json();
//        $data = $json['data']['Invoices'] ?? [];
//        $total = $json['data']['TotalPage'] ?? count($data);
//
//        // ✅ Create paginator
//        $paginator = new LengthAwarePaginator(
//            $data,
//            $total,
//            $perPage,
//            $page,
//            ['path' => url()->current(), 'query' => request()->query()]
//        );
//
//        return view('admin.external_services.index', [
//            'invoices' => $paginator,
//            'date' => $date,
//        ]);
//    }
//    public function index()
//    {
//        $specificToken = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwO';
//        $apiUrl = route('get-all-invoices');
//        $date = request('date', now()->format('Y-m'));
//        $page = request('page', 1);
//        $perPage = 50;
//
//        $response = Http::withToken($specificToken)->get($apiUrl, [
//            'date' => $date,
//            'per_page' => $perPage,
//            'page' => $page,
//        ]);
//
//        if ($response->failed()) {
//            if (request()->ajax()) {
//                return response()->json(['error' => 'Failed to fetch invoices'], 500);
//            }
//            return back()->with('error', 'فشل في جلب البيانات من API.');
//        }
//
//        $json = $response->json();
//        $invoices = $json['data']['Invoices'] ?? [];
//        $totalPages = $json['data']['TotalPage'] ?? 1;
//
//        // ✅ If AJAX request (Load More)
//        if (request()->ajax()) {
//            return response()->json([
//                'invoices' => view('admin.external_services.invoice_rows_ajax', ['invoices' => $invoices, 'startIndex' => $page * $perPage - $perPage])->render(),
//                'page' => $page,
//                'totalPages' => $totalPages,
//            ]);
//        }
//
//        // Normal page load
//        return view('admin.external_services.index', [
//            'invoices' => $invoices,
//            'date' => $date,
//            'totalPages' => $totalPages,
//            'currentPage' => $page,
//            'startIndex' => $page * $perPage - $perPage
//        ]);
//    }
    public function index(Request $request)
    {


        $monthYear = $request->get('date', now()->format('Y-m')); // e.g. "2025-05"
//        $monthYear = $request->get('date', "2025-10"); // e.g. "2025-05"


        [$year, $month] = explode('-', $monthYear);

        // ✅ Get all merchants with their orders for that month
//        $query = Order::with([
//            'merchant',
//            'package.category'
//        ])
//            ->whereNotNull('parent_id')
//            ->where('paid_order', 'paid')
//            ->whereYear('created_at', $year)
//            ->whereMonth('created_at', $month)
//            ->select('id', 'merchant_id', 'package_id', 'company_name', 'name', 'count', 'merchant_price', 'created_at')
//            ->orderBy('merchant_id')
//            ->paginate(20);
        // 1️⃣ Aggregate at database level per merchant
        $query = Order::query()
            ->whereNotNull('parent_id')
            ->where('paid_order', 'paid')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->selectRaw('
            merchant_id,
         
            MAX(created_at) as last_order_at
        ')
            ->groupBy('merchant_id')
            ->with(['merchant:id,name,tax_number,commercial_number,city_id', 'merchant.city:id,name_ar'])
            ->orderBy('merchant_id')
            ->paginate(5);

        $query->appends($request->except('page'));


        // Normal page load
        return view('admin.external_services.index', [
            'invoices'    => $query,
            'date'        => $monthYear,
        ]);
    }
    public function details($merchant_id, Request $request)
    {
        $monthYear = $request->get('date', now()->format('Y-m'));
        [$year, $month] = explode('-', $monthYear);

        $orders = Order::with('package.category')
            ->where('merchant_id', $merchant_id)
            ->whereNotNull('parent_id')
            ->where('paid_order', 'paid')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->select('id', 'package_id', 'company_name', 'count', 'merchant_price')
            ->get();

        $items = $orders->groupBy('package_id')->map(function ($orders) {
            $first = $orders->first();

            $totalForPackage = (float) $orders->sum('merchant_price');
            $quantity = (int) $orders->sum('count');

            return [
                'ItemCode' => $first->package_id,
                'ItemName' => (
                    ($first->company_name[app()->getLocale()] ?? '') . ' ' .
                    ($first->package->category->name[app()->getLocale()] ?? '') . ' ' .
                    ($first->package->name[app()->getLocale()] ?? '')
                ),
                'Quantity' => $quantity,
                // keep numeric to ease JS formatting
                'Total' => round($totalForPackage, 2),
            ];
        })->values();

        // Compute merchant total from items (same source)
        $merchantTotal = (float) $items->sum('Total');

        return response()->json([
            'items' => $items,
            'merchant_total' => round($merchantTotal, 2),
        ]);
    }



}
