<?php

namespace App\Filters;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TransferFilters
{
    public static function apply($query, Request $request)
    {
        // Type
        $query->where('userable_type', getClassModel($request->type));

        // Process type
        if ($request->process_type) {
            $query->where('type', $request->process_type);
        }

        // User name
        if ($request->user_name) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'LIKE', "%{$request->user_name}%");
            });
        }

        // User ID
        if ($request->user_id) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('id', 'LIKE', "%{$request->user_id}%");
            });
        }

        // Date filters
        if ($request->time == "today") {
            $query->whereDate('created_at', Carbon::today());
        }

        if ($request->time == "yesterday") {
            $query->whereDate('created_at', Carbon::yesterday());
        }

        if ($request->time == "current_week") {
            $query->whereBetween('created_at', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ]);
        }

        if ($request->time == "current_month") {
            $query->whereBetween('created_at', [
                Carbon::now()->startOfMonth(),
                Carbon::now()->endOfMonth()
            ]);
        }

        if ($request->time == "month_ago") {
            $query->whereMonth('created_at', Carbon::now()->subMonth()->month);
        }

        if ($request->time == "exact_time") {
            $startDate = Carbon::parse($request->from_date);
            $endDate = Carbon::parse($request->to_date);
            $query->whereBetween(DB::raw('DATE(created_at)'), [
                $startDate,
                $endDate
            ]);
        }

        return $query;
    }
}
