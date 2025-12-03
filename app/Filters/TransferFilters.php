<?php

namespace App\Filters;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TransferFilters
{
    public static function apply($query, Request $request)
    {
        $time = $request->time;
        if ($time == "today") {
             $query->whereDate('created_at', Carbon::now());
        }
        if ($time == "exact_time"){
            $startDate = Carbon::parse($request->from_date);
            $endDate = Carbon::parse($request->to_date);

            $query->whereBetween(\DB::raw('DATE(created_at)'), [$startDate, $endDate]);
        }


        return $query;
    }
}
