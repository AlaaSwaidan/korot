<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class WalletsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return DB::table('wallets')
            ->join('transfers', 'wallets.transfer_id', '=', 'transfers.id')
            ->join('merchants', 'wallets.merchant_id', '=', 'merchants.id')
            ->whereBetween(DB::raw('DATE(wallets.created_at)'), ['2025-09-01', '2025-10-30'])
            ->whereColumn('wallets.balance', 'transfers.amount')
            ->select(
                'merchants.id as user_id',
                'merchants.name as user_name',
                'wallets.balance as wallet_balance',
                'merchants.balance as current_balance',
                'wallets.created_at as created_at',
            )
            ->get();
    }

    public function headings(): array
    {
        return ['رقم التاجر','اسم التاجر', 'المبلغ', 'الرصيد الحالي','تاريخ الشحن'];
    }
}
