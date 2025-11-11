<?php
// 🧠 If this resource receives a collection of orders for a merchant:
$merchant = $invoice->first()?->merchant ?? $invoice->merchant;

// Group orders by package_id for this merchant
$itemsGrouped = $invoice->groupBy('package_id')->map(function ($orders) {
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

$monthYear = \request()->get('date',now()->format('Y-m')); // e.g. "2025-05"
[$year, $month] = explode('-', $monthYear);
$monthYearId = $year . sprintf('%02d', $month) . '-' . $merchant->id;

$lastDay = \Carbon\Carbon::createFromFormat('Y-m', $monthYear)->endOfMonth()->toDateString();
    ?>

<tr>
    <td>{{ $index + 1 }}</td>
    <td>{{ $monthYearId }}</td>
    <td>{{ $merchant->id }}</td>
    <td>{{ $merchant->name}}</td>
    <td>{{ $merchant->tax_number }}</td>
    <td>{{ $merchant->commercial_number }}</td>
    <td>{{ optional($merchant->city)->name_ar }}</td>
    <td><div class="badge badge-light-success">{{ round($itemsGrouped->sum('Total'), 2) }} ر.س</div></td>
    <td>{{ $lastDay }}</td>
    <td>
        <button class="btn btn-sm btn-light-primary" data-bs-toggle="collapse" data-bs-target="#items-{{ $index }}">
            عرض العناصر
        </button>
    </td>
</tr>

<tr class="collapse bg-light" id="items-{{ $index }}">
    <td colspan="7">
        <table class="table align-middle table-row-dashed fs-6 gy-5" style="text-align: center;">
            <thead class="bg-secondary">
            <tr>
                <th>الكود</th>
                <th>اسم العنصر</th>
                <th>الكمية</th>
                <th>الإجمالي</th>
            </tr>
            </thead>
            <tbody>

            @foreach($itemsGrouped as $item)
                <tr>
                    <td>{{ $item['ItemCode'] }}</td>
                    <td>{{ $item['ItemName'] }}</td>
                    <td>{{ $item['Quantity'] }}</td>
                    <td>{{ number_format($item['Total'], 2) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </td>
</tr>
