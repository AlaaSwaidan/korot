<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
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
    public function index()
    {
        $specificToken = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwO';
        $apiUrl = route('get-all-invoices');
        $date = request('date', now()->format('Y-m'));
        $page = request('page', 1);
        $perPage = 50;

        $response = Http::withToken($specificToken)->get($apiUrl, [
            'date' => $date,
            'per_page' => $perPage,
            'page' => $page,
        ]);

        if ($response->failed()) {
            if (request()->ajax()) {
                return response()->json(['error' => 'Failed to fetch invoices'], 500);
            }
            return back()->with('error', 'فشل في جلب البيانات من API.');
        }

        $json = $response->json();
        $invoices = $json['data']['Invoices'] ?? [];
        $totalPages = $json['data']['TotalPage'] ?? 1;

        // ✅ If AJAX request (Load More)
        if (request()->ajax()) {
            return response()->json([
                'invoices' => view('admin.external_services.invoice_rows_ajax', ['invoices' => $invoices, 'startIndex' => $page * $perPage - $perPage])->render(),
                'page' => $page,
                'totalPages' => $totalPages,
            ]);
        }

        // Normal page load
        return view('admin.external_services.index', [
            'invoices' => $invoices,
            'date' => $date,
            'totalPages' => $totalPages,
            'currentPage' => $page,
            'startIndex' => $page * $perPage - $perPage
        ]);
    }

}
