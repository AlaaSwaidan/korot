<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class ExternalServiceResource extends JsonResource
{
    public function toArray($request)
    {
        // 🧠 If this resource receives a collection of orders for a merchant:
        $merchant = $this->first()?->merchant ?? $this->merchant;

        // Group orders by package_id for this merchant
        $itemsGrouped = $this->groupBy('package_id')->map(function ($orders) {
            $first = $orders->first();

            return [
                'ItemCode' => $first->package_id,
                'ItemName' =>
                    ($first->company_name[app()->getLocale()] ?? '') . ' ' .
                    ($first->package->category->name[app()->getLocale()] ?? '') . ' ' .
                    ($first->package->name[app()->getLocale()] ?? ''),
                'Quantity' => (int) $orders->sum('count'),
                'Total' => round($orders->sum('merchant_price'), 2),
            ];
        })->values();

        $monthYear = $request->get('date'); // e.g. "2025-05"
        [$year, $month] = explode('-', $monthYear);
        $monthYearId = $year . sprintf('%02d', $month) . '-' . $merchant->id;
        return [
            // 🧾 Invoice
            'InvoiceID'   =>$monthYearId,
            'InvoiceDate' => now()->format('Y-m-d'),
            'Total'       => round($itemsGrouped->sum('Total'), 2),

            // 👤 Customer Info
            'Customer' => [
                'ID'                 => $merchant->id,
                'Name'               => $merchant->name,
                'TaxNumber'          => $merchant->tax_number,
                'RegistrationNumber' => $merchant->commercial_number,
                'City'               => optional($merchant->city)->name_ar,
                'Street'             => $merchant->street,
                'Distinct'           => $merchant->distinct,
                'ZipCode'            => $merchant->zipcode,
                'BuildingNo'         => $merchant->building_number,
                'ExtraNo'            => $merchant->extra_number,
            ],

            // 📦 Items (packages)
            'Items' => $itemsGrouped,
        ];
    }
}
